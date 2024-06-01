# Upgrading

## From v1 to v2

Version 2.x is a complete rewrite, so there isn't a step-by-step upgrade guide. We recommend you to read the updated docs
and update your code with the renamed methods and classes.

Some major changes are:

- **Currency amounts handled in cents as integer**
- New request constructor:
```php
// From
$redsysRequest = new RedsysRequest($redsysClient);
$redsysRequest->createPaymentRequest(
    amount: 123.45,
    order: '22013100005',
    currency: Currency::EUR,
    transactionType: TransactionType::Autorizacion,
);

// To
$redsysRequest = RedsysRequest::create(
    $redsysClient,
    new RequestParameters(
        amountInCents: 123_45,
        order: '22013100005',
        currency: Currency::EUR,
        transactionType: TransactionType::Autorizacion,
        merchantUrl: 'https://example.com/redsysNotification',
        urlOk: 'https://example.com/paymentOk',
        urlKo: 'https://example.com/paymentKo',
    )
);
```
- Return redirection form method renamed from `$redsysRequest->getFormHtml()` to `$redsysRequest->getRedirectFormHtml()`

