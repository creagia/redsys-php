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
});

it('can create redirect form', function () {
    $redsysRequest = \Creagia\Redsys\RedsysRequest::create(
        $this->redsysClient,
        new RequestParameters(
            amountInCents: 123_12,
            order: 9999,
            currency: Currency::EUR,
            transactionType: TransactionType::Autorizacion,
        )
    );

    $redirectForm = $redsysRequest->getRedirectFormHtml();

    $this->assertStringContainsString('realizarPago', $redirectForm);
});

it('can create redirect with extra parameters', function () {
    $redsysRequest = \Creagia\Redsys\RedsysRequest::create(
        $this->redsysClient,
        new RequestParameters(
            amountInCents: 123_12,
            order: 9999,
            currency: Currency::EUR,
            transactionType: TransactionType::Autorizacion,
            merchantUrl: 'https://example.com/redsysNotification',
            urlOk: 'https://example.com/paymentOk',
            urlKo: 'https://example.com/paymentKo',
            consumerLanguage: ConsumerLanguage::Auto,
            payMethods: PayMethod::Card,
            productDescription: 'Product description',
        )
    );

    $redirectForm = $redsysRequest->getRedirectFormHtml();

    $this->assertStringContainsString('realizarPago', $redirectForm);
});
