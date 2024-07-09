<?php

it('can validate a valid signature', function (
    \Creagia\Redsys\RedsysClient $redsysClient,
    int $paymentRequestAmount,
    \Creagia\Redsys\RedsysFakeGateway $redsysFakeGateway
) {
    $responsePost = $redsysFakeGateway->getResponse('0000');

    $redsysNotification = new \Creagia\Redsys\RedsysResponse($redsysClient);
    $redsysNotification->setParametersFromResponse($responsePost);
    $result = $redsysNotification->checkResponse();

    expect($result->amount)->toBe($paymentRequestAmount);
})->with('gateway');

it('fails if signatures differ', function (
    \Creagia\Redsys\RedsysClient $redsysClient,
    int $paymentRequestAmount,
    \Creagia\Redsys\RedsysFakeGateway $redsysFakeGateway
) {
    $responsePost = $redsysFakeGateway->getResponse('0000');
    $responsePost['Ds_Signature'] = "123";

    $redsysNotification = new \Creagia\Redsys\RedsysResponse($redsysClient);
    $redsysNotification->setParametersFromResponse($responsePost);
    $redsysNotification->checkResponse();
})
    ->with('gateway')
    ->throws(\Creagia\Redsys\Exceptions\InvalidRedsysResponseException::class, 'does not match');

it('throws an exception if invalid response from Redsys', function (
    \Creagia\Redsys\RedsysClient $redsysClient,
    int $paymentRequestAmount,
    \Creagia\Redsys\RedsysFakeGateway $redsysFakeGateway
) {
    $redsysNotification = new \Creagia\Redsys\RedsysResponse($redsysClient);
    $redsysNotification->setParametersFromResponse([]);
    $redsysNotification->checkResponse();
})
    ->with('gateway')
    ->throws(\Creagia\Redsys\Exceptions\InvalidRedsysResponseException::class);

it('throws an exception if denied response from Redsys', function (
    \Creagia\Redsys\RedsysClient $redsysClient,
    int $paymentRequestAmount,
    \Creagia\Redsys\RedsysFakeGateway $redsysFakeGateway
) {
    $responsePost = $redsysFakeGateway->getResponse('0184');

    $redsysNotification = new \Creagia\Redsys\RedsysResponse($redsysClient);
    $redsysNotification->setParametersFromResponse($responsePost);
    $redsysNotification->checkResponse();
})
    ->with('gateway')
    ->throws(\Creagia\Redsys\Exceptions\DeniedRedsysPaymentResponseException::class);

$redsysClient = new \Creagia\Redsys\RedsysClient(
    merchantCode: 123123,
    secretKey: 123123,
    terminal: 1,
    environment: \Creagia\Redsys\Enums\Environment::Production,
);

dataset('gateway', [
    [
        $redsysClient,
        $paymentRequestAmount = 123_12,
        function () use ($redsysClient, $paymentRequestAmount) {
            $redsysRequest = \Creagia\Redsys\RedsysRequest::create(
                $redsysClient,
                new \Creagia\Redsys\Support\RequestParameters(
                    amountInCents: $paymentRequestAmount,
                    transactionType: \Creagia\Redsys\Enums\TransactionType::Autorizacion,
                    currency: \Creagia\Redsys\Enums\Currency::EUR,
                    order: 9999,
                )
            );

            return $this->redsysFakeGateway = new \Creagia\Redsys\RedsysFakeGateway(
                $redsysRequest->getRequestFieldsArray(),
                123123
            );
        },
    ],
    [
        $redsysClient,
        $paymentRequestAmount = 0,
        function () use ($redsysClient, $paymentRequestAmount) {
            $redsysRequest = \Creagia\Redsys\RedsysRequest::create(
                $redsysClient,
                new \Creagia\Redsys\Support\RequestParameters(
                    amountInCents: $paymentRequestAmount,
                    transactionType: \Creagia\Redsys\Enums\TransactionType::Autorizacion,
                    currency: \Creagia\Redsys\Enums\Currency::EUR,
                    order: 9999,
                )
            );

            return $this->redsysFakeGateway = new \Creagia\Redsys\RedsysFakeGateway(
                $redsysRequest->getRequestFieldsArray(),
                123123
            );
        },
    ],
]);
