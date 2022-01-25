<?php

beforeEach(function () {
    $this->redsysClient = new \Creagia\Redsys\RedsysClient(
        merchantCode: 123123,
        secretKey: 123123,
        terminal: 1,
        environment: \Creagia\Redsys\Enums\Environment::Production,
    );

    $redsysRequest = new \Creagia\Redsys\RedsysRequest($this->redsysClient);
    $this->paymentRequestFields = $redsysRequest->createPaymentRequest(
        amount: $this->paymentRequestAmount = 123.12,
        orderNumber: 9999,
        currency: \Creagia\Redsys\Enums\Currency::EUR,
        transactionType: \Creagia\Redsys\Enums\TransactionType::AutenticacionPuce
    );

    $this->redsysFakeGateway = new \Creagia\Redsys\RedsysFakeGateway($this->paymentRequestFields, 123123);
});

it('can validate a valid signature', function () {
    $responsePost = $this->redsysFakeGateway->getResponse('0000');

    $redsysNotification = new \Creagia\Redsys\RedsysNotification($this->redsysClient);
    $redsysNotification->setParametersFromResponse($responsePost);
    $result = $redsysNotification->checkResponse();

    expect($result->getAmount())->toBe($this->paymentRequestAmount);
});

it('fails if signatures differ', function () {
    $responsePost = $this->redsysFakeGateway->getResponse('0000');
    $responsePost['Ds_Signature'] = "123";

    $redsysNotification = new \Creagia\Redsys\RedsysNotification($this->redsysClient);
    $redsysNotification->setParametersFromResponse($responsePost);
    $redsysNotification->checkResponse();
})->throws(\Creagia\Redsys\Exceptions\InvalidRedsysNotification::class, 'does not match');

it('throws an exception if invalid response from Redsys', function () {
    $redsysNotification = new \Creagia\Redsys\RedsysNotification($this->redsysClient);
    $redsysNotification->setParametersFromResponse([]);
    $redsysNotification->checkResponse();
})->throws(\Creagia\Redsys\Exceptions\InvalidRedsysNotification::class);

it('throws an exception if denied response from Redsys', function () {
    $responsePost = $this->redsysFakeGateway->getResponse('0184');

    $redsysNotification = new \Creagia\Redsys\RedsysNotification($this->redsysClient);
    $redsysNotification->setParametersFromResponse($responsePost);
    $redsysNotification->checkResponse();
})->throws(\Creagia\Redsys\Exceptions\DeniedRedsysPaymentNotification::class);
