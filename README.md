# Online payments with Redsys

[![Latest Version on Packagist](https://img.shields.io/packagist/v/creagia/redsys-php.svg?style=flat-square)](https://packagist.org/packages/creagia/redsys-php)
[![Tests](https://github.com/creagia/redsys-php/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/creagia/redsys-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/creagia/redsys-php.svg?style=flat-square)](https://packagist.org/packages/creagia/redsys-php)

Integrate your PHP code with Redsys, the lead payments gateway in Spain.

> If you are using Laravel, check our other package **[creagia/laravel-redsys](https://github.com/creagia/laravel-redsys)** for a ready-to-use integration.

## Installation

You can install the package via composer:

```bash
composer require creagia/redsys-php
```

## Usage

This package supports redirection and REST integration methods.
You can learn more about the available integration methods on the [official website](https://pagosonline.redsys.es/modelos-de-integracion.html).

* [Creating a request](#create-request)
* [Receive notifications from Redsys](#receive-notifications)
* [Environments](#environments)

<a name="create-request"></a>
### Creating a request

```php
use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\RedsysClient;
use Creagia\Redsys\RedsysRequest;
use Creagia\Redsys\Support\RequestParameters;

$redsysClient = new RedsysClient(
    merchantCode: env('redsys.merchantCode'),
    secretKey: env('redsys.key'),
    terminal: env('redsys.terminal'),
    environment: \Creagia\Redsys\Enums\Environment::Test,
);

$redsysRequest = RedsysRequest::create(
    $redsysClient,
    new RequestParameters(
        amountInCents: 123_45,
        orderNumber: '22013100005',
        currency: Currency::EUR,
        transactionType: TransactionType::Autorizacion,
        merchantUrl: 'https://example.com/redsysNotification',
        urlOk: 'https://example.com/paymentOk',
        urlKo: 'https://example.com/paymentKo',
    )
);

echo $redsysRequest->getRedirectFormHtml()
```

First, you need to create a `RedsysClient` with your environment configuration. After that, you should create
a `RedsysRequest` using your client and your `RequestParameters`.

Apart from the mandatory fields, you may define any extra optional field (like `merchantUrl` as the notification URL or `urlOk`
and `urlKo` to redirect the users after paying) as your `RequestParameters` arguments.

Finally, you can return the redirection form with the `getRedirectFormHtml()` 
method or send the post request using the `sendPostRequest()`. 
Read more about those integration methods on the Redsys documentation:

- [Redirection](https://pagosonline.redsys.es/conexion-redireccion.html)
- [REST](https://pagosonline.redsys.es/conexion-rest.html)

#### Creating Credential-On-File (token) requests
While you can create [Credential-On-File](https://pagosonline.redsys.es/funcionalidades-COF.html) configuring your
`RequestParameters` as defined on Redsys documentation, this packages provides some helpers to make it easier.

```php
use Creagia\Redsys\RedsysRequest;
use Creagia\Redsys\Support\RequestParameters;
use Creagia\Redsys\Enums\CofType;

$redsysRequest = RedsysRequest::create(
    redsysClient: $redsysClient,
    requestParameters: new RequestParameters(...)
)->requestingCardToken(
    cofType: CofType::Recurring
);

echo $redsysRequest->getRedirectFormHtml()
```

You can also send your request using the REST API as a post request:
```php
use Creagia\Redsys\RedsysRequest;
use Creagia\Redsys\Support\RequestParameters;

$redsysRequest = RedsysRequest::create(
    redsysClient: $redsysClient,
    requestParameters: new RequestParameters(...)
)->usingCardToken(
    cofType: CofType::Recurring,
    cofTransactionId: $cofTransactionId,
    merchantIdentifier: $merchantIdentifier,
);

$response = $redsysRequest->sendPostRequest();
```

<a name="receive-notifications"></a>
### Receive notifications from Redsys

If you defined the `merchantUrl` parameter during the payment request creation, Redsys will post that URL with the result, so you can
execute any actions on an authorised or denied request.

Keep in mind that Redsys won't notify you on abandoned payments so this `merchantUrl` won't be notified for every payment
request created. Only when the payment finishes. You should take care of abandoned/pending requests.

```php
use Creagia\Redsys\Exceptions\DeniedRedsysPaymentResponseException;
use Creagia\Redsys\RedsysClient;
use Creagia\Redsys\RedsysResponse;

$redsysClient = new RedsysClient(
    merchantCode: env('redsys.merchantCode'),
    secretKey: env('redsys.key'),
    terminal: env('redsys.terminal'),
    environment: \Creagia\Redsys\Enums\Environment::Test,
);

$redsysNotification = new RedsysResponse($redsysClient);
$redsysNotification->setParametersFromResponse($_POST);

// If you need it, prior to checking response, you can use the decoded data from
// Redsys accessing the `NotificationParameters` object on `$redsysNotification->parameters`. 

try {
    $notificationData = $redsysNotification->checkResponse();
    // Authorised payment
} catch (DeniedRedsysPaymentResponseException $e) {
    $errorMessage = $e->getMessage();
    // Denied payment with $errorMessage
}
```

<a name="environments"></a>
### Custom environments
When creating a `RedsysClient` you may define the right environment for your requests. That environment
will be used to send requests to the production or testing Redsys environment.

#### Custom environments
You can define the environment property to `Environment::Custom`.
In that case, you will also need to define the `customBaseUrl` propierty.

This feature enables you to use any mock or fake Redsys gateway to test you application locally, for example.

You can find an example on that on our Laravel package [creagia/laravel-redsys](https://github.com/creagia/laravel-redsys), which
features a local gateway to test your integration locally.

```php
$redsysClient = new RedsysClient(
    merchantCode: env('redsys.merchantCode'),
    secretKey: env('redsys.key'),
    terminal: env('redsys.terminal'),
    environment: \Creagia\Redsys\Enums\Environment::Custom,
    customBaseUrl: 'https://localGateway.test',
);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

<a name="alternatives"></a>
## Alternatives

- [eusonlito/redsys-TPV](https://github.com/eusonlito/redsys-TPV) PHP >=5.3
- [Official Redsys](https://pagosonline.redsys.es/conexion-redireccion.html)

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [David Torras](https://github.com/dtorras)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
