<?php

use Creagia\Redsys\Enums\CofType;
use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\RedsysRequest;
use Creagia\Redsys\RedsysResponse;
use Creagia\Redsys\Support\Signature;

beforeEach(function () {
    $this->redsysClient = new \Creagia\Redsys\RedsysClient(
        merchantCode: 123123,
        secretKey: 123123,
        terminal: 1,
        environment: \Creagia\Redsys\Enums\Environment::Test
    );
    $this->order = 9999;
});

it('can create redirect form for credential on file requests', function () {
    $redsysRequest = RedsysRequest::create(
        $this->redsysClient,
        new \Creagia\Redsys\Support\RequestParameters(
            amountInCents: 123_12,
            order: $this->order,
            currency: Currency::EUR,
            transactionType: TransactionType::Autorizacion,
        )
    )->requestingCardToken(
        cofType: CofType::Recurring
    );

    $redirectForm = $redsysRequest->getRedirectFormHtml();

    $this->assertStringContainsString('realizarPago', $redirectForm);
});

it('receives an error response from redsys', function () {
    $errorCode = 'SISXXXX';

    $response = new GuzzleHttp\Psr7\Response(
        body: json_encode([
            'errorCode' => $errorCode,
        ])
    );
    $mock = $this->createMock(GuzzleHttp\Client::class);

    $redsysRequest = getRedsysRequest($this, $mock, $response);

    $postResponse = $redsysRequest->sendPostRequest();

    expect($postResponse)->toBeInstanceOf(\Creagia\Redsys\Support\PostRequestError::class)
        ->and($postResponse->code)->toBe($errorCode);
});

it('receives an invalid response from bank', function () {
    $response = new GuzzleHttp\Psr7\Response(
        body: json_encode([
            'invalidResponse' => '',
        ])
    );

    $mock = $this->createMock(GuzzleHttp\Client::class);

    $redsysRequest = getRedsysRequest($this, $mock, $response);

    $redsysRequest->sendPostRequest();
})->throws(Creagia\Redsys\Exceptions\InvalidRedsysResponseException::class);

it('can post for successive credential on file requests', function () {
    $signature = 'signature';
    $merchantParameters = getMerchantParameters($this->order, 0);

    $response = new GuzzleHttp\Psr7\Response(
        body: json_encode([
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => $merchantParameters,
            'Ds_Signature' => $signature,
        ])
    );

    $mock = $this->createMock(GuzzleHttp\Client::class);

    $redsysRequest = getRedsysRequest($this, $mock, $response);

    $postResponse = $redsysRequest->sendPostRequest();

    expect($postResponse)
        ->toBeInstanceOf(RedsysResponse::class)
        ->and($postResponse->receivedSignature)->toBe($signature)
        ->and($postResponse->originalEncodedMerchantParameters)->toBe($merchantParameters);
});

it('does not match signatures', function () {
    $signature = 'invalidSignature-rcME=';
    $merchantParameters = getMerchantParameters($this->order, 100);
    $response = new GuzzleHttp\Psr7\Response(
        body: json_encode([
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => $merchantParameters,
            'Ds_Signature' => $signature,
        ])
    );

    $mock = $this->createMock(GuzzleHttp\Client::class);

    $redsysRequest = getRedsysRequest($this, $mock, $response);

    $postResponse = $redsysRequest->sendPostRequest();
    $postResponse->checkResponse();
})->throws(Creagia\Redsys\Exceptions\InvalidRedsysResponseException::class);

it('matches signatures but is not authorised', function () {
    $merchantParameters = getMerchantParameters($this->order, 100);
    $signature = Signature::calculateSignature(
        encodedParameters: $merchantParameters,
        order: $this->order,
        secretKey: $this->redsysClient->secretKey,
    );
    $response = new GuzzleHttp\Psr7\Response(
        body: json_encode([
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => $merchantParameters,
            'Ds_Signature' => $signature,
        ])
    );

    $mock = $this->createMock(GuzzleHttp\Client::class);

    $redsysRequest = getRedsysRequest($this, $mock, $response);

    $postResponse = $redsysRequest->sendPostRequest();
    $postResponse->checkResponse();
})->throws(Creagia\Redsys\Exceptions\DeniedRedsysPaymentResponseException::class);


it('matches signatures and is authorised', function () {
    $merchantParameters = getMerchantParameters($this->order, 99);
    $signature = Signature::calculateSignature(
        encodedParameters: $merchantParameters,
        order: $this->order,
        secretKey: $this->redsysClient->secretKey,
    );
    $response = new GuzzleHttp\Psr7\Response(
        body: json_encode([
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => $merchantParameters,
            'Ds_Signature' => $signature,
        ])
    );

    $mock = $this->createMock(GuzzleHttp\Client::class);

    $redsysRequest = getRedsysRequest($this, $mock, $response);

    $postResponse = $redsysRequest->sendPostRequest();
    $parameters = $postResponse->checkResponse();

    expect($parameters)
        ->toBeInstanceOf(\Creagia\Redsys\Support\NotificationParameters::class);
});

function getRedsysRequest(
    \PHPUnit\Framework\TestCase $testCase,
    \PHPUnit\Framework\MockObject\MockObject $mockClient,
    GuzzleHttp\Psr7\Response $response
): RedsysRequest {
    $mockClient
        ->expects(\PHPUnit\Framework\TestCase::once())
        ->method('send')
        ->willReturn($response);

    $redsysRequest = RedsysRequest::create(
        $testCase->redsysClient,
        new \Creagia\Redsys\Support\RequestParameters(
            amountInCents: 123_12,
            order: $testCase->order,
            currency: Currency::EUR,
            transactionType: TransactionType::Autorizacion
        ),
        $mockClient
    )->usingCardToken(
        cofType: CofType::Recurring,
        cofTransactionId: '123123',
        merchantIdentifier: 'identifier123',
    );

    return $redsysRequest;
}

function getMerchantParameters(int $order, int $responseCode): string
{
    $merchantParameters = [
        "Ds_Amount" => "145",
        "Ds_Currency" => "978",
        "Ds_Order" => "$order",
        "Ds_MerchantCode" => "999008881",
        "Ds_Terminal" => "1",
        "Ds_Response" => "$responseCode",
        "Ds_TransactionType" => "0",
        "Ds_SecurePayment" => "0",
        "Ds_Language" => "1",
        "Ds_CardNumber" => "454881********04",
        "Ds_MerchantData" => "",
        "Ds_Card_Country" => "724",
        "Ds_AuthorisationCode" => "501602",
        "Ds_Card_Brand" => "1",
    ];
    return base64_encode(urlencode(json_encode($merchantParameters)));

}
