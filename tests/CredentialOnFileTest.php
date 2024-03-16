<?php

use Creagia\Redsys\Enums\CofType;
use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\RedsysRequest;

beforeEach(function () {
    $this->redsysClient = new \Creagia\Redsys\RedsysClient(
        merchantCode: 123123,
        secretKey: 123123,
        terminal: 1,
        environment: \Creagia\Redsys\Enums\Environment::Test
    );
});

it('can create redirect form for credential on file requests', function () {
    $redsysRequest = RedsysRequest::create(
        $this->redsysClient,
        new \Creagia\Redsys\Support\RequestParameters(
            amountInCents: 123_12,
            order: 9999,
            currency: Currency::EUR,
            transactionType: TransactionType::Autorizacion,
        )
    )->requestingCardToken(
        cofType: CofType::Recurring
    );

    $redirectForm = $redsysRequest->getRedirectFormHtml();

    $this->assertStringContainsString('realizarPago', $redirectForm);
});

it('can post for successive credential on file requests', function () {
    $redsysRequest = RedsysRequest::create(
        $this->redsysClient,
        new \Creagia\Redsys\Support\RequestParameters(
            amountInCents: 123_12,
            order: 9999,
            currency: Currency::EUR,
            transactionType: TransactionType::Autorizacion
        ),
    )->usingCardToken(
        cofType: CofType::Recurring,
        cofTransactionId: '123123',
        merchantIdentifier: 'identifier123',
    );

    $this->markTestSkipped('todo mock response');
//    $postResponse = $redsysRequest->sendPostRequest();
//    $this->assertTrue($postResponse instanceof \Creagia\Redsys\Support\NotificationParameters);
});
