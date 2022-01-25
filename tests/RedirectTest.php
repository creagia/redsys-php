<?php

use Creagia\Redsys\Enums\ConsumerLanguage;
use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\PayMethod;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\Support\RequestParameters;

beforeEach(function () {
    $this->redsysClient = new \Creagia\Redsys\RedsysClient(
        merchantCode: 123123,
        secretKey: 123123,
        terminal: 1,
        environment: \Creagia\Redsys\Enums\Environment::Production
    );
    $this->redsysRequest = new \Creagia\Redsys\RedsysRequest($this->redsysClient);
});

it('can create redirect form', function () {
    $this->redsysRequest->createPaymentRequest(
        amount: 123.12,
        orderNumber: 9999,
        currency: Currency::EUR,
        transactionType: TransactionType::Autorizacion
    );

    $redirectForm = $this->redsysRequest->getFormHtml();

    $this->assertStringContainsString('realizarPago', $redirectForm);
});

it('can create redirect with extra parameters', function () {
    $this->redsysRequest->createPaymentRequest(
        amount: 123.12,
        orderNumber: 9999,
        currency: Currency::EUR,
        transactionType: TransactionType::Autorizacion,
        requestParameters: new RequestParameters(
            merchantUrl: 'https://example.com/redsysNotification',
            urlOk: 'https://example.com/paymentOk',
            urlKo: 'https://example.com/paymentKo',
            consumerLanguage: ConsumerLanguage::Auto->value,
            payMethods: PayMethod::Card->value,
            productDescription: 'Product description',
        ),
    );

    $redirectForm = $this->redsysRequest->getFormHtml();

    $this->assertStringContainsString('realizarPago', $redirectForm);
});
