# Online payments with Redsys in PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/creagia/redsys-php.svg?style=flat-square)](https://packagist.org/packages/creagia/redsys-php)
[![Tests](https://github.com/creagia/redsys-php/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/creagia/redsys-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/creagia/redsys-php.svg?style=flat-square)](https://packagist.org/packages/creagia/redsys-php)

Integrate your PHP code with Redsys, the lead payment gateway in Spain. This package only works on 8.1 and newer versions. If you
need compatibility with older versions, check the [Alternatives](#alternatives) section.

If you are using Laravel, check our other package [creagia/laravel-redsys](https://github.com/creagia/laravel-redsys) for a ready-to-use integration.

## Installation

You can install the package via composer:

```bash
composer require creagia/redsys-php
```

## Usage

For now, the only method tested in this package is the redirection one. REST and SOAP integration are on the roadmap for future versions.
You can learn more about the available integration methods on the [official website](https://pagosonline.redsys.es/modelos-de-integracion.html).

* [Create payment and redirect to Redsys](#create-payment)
* [Receive notifications from Redsys](#receive-notifications)
* [Custom environments](#custom-environments)

<a name="create-payment"></a>
### Create payment and redirect to Redsys

```php
use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\RedsysClient;
use Creagia\Redsys\RedsysRequest;

$redsysClient = new RedsysClient(
    merchantCode: env('redsys.merchantCode'),
    secretKey: env('redsys.key'),
    terminal: env('redsys.terminal'),
    environment: \Creagia\Redsys\Enums\Environment::Test,
);

$redsysRequest = new RedsysRequest($redsysClient);
$redsysRequest->createPaymentRequest(
    amount: 123.45,
    orderNumber: '22013100005',
    currency: Currency::EUR,
    transactionType: TransactionType::Autorizacion,
);

echo $redsysRequest->getFormHtml();
```

#### Adding optional parameters to the payment request
Apart from mandatory fields, you can define any extra optional field (like `merchantUrl` as the notification URL or `urlOk`
and `urlKo` to redirect the users after paying) using an `InputParameters` object as optional parameter.

```php
use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\Enums\ConsumerLanguage;
use Creagia\Redsys\Support\RequestParameters;

$redsysRequest->createPaymentRequest(
    amount: 123.45,
    orderNumber: '22013100005',
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
```

<a name="receive-notifications"></a>
### Receive notifications from Redsys

If you defined `merchantUrl` during the payment request creation, Redsys will post that URL with the result, so you can
execute any actions on an authorised or denied payment.

Keep in mind that Redsys won't notify you on abandoned payments so this `merchantUrl` won't be notified for every payment
request created. Only when the payment finishes. You should take care of abandoned/pending payments.

```php
use Creagia\Redsys\Exceptions\DeniedRedsysPaymentNotification;
use Creagia\Redsys\RedsysClient;
use Creagia\Redsys\RedsysNotification;

$redsysClient = new RedsysClient(
    merchantCode: env('redsys.merchantCode'),
    secretKey: env('redsys.key'),
    terminal: env('redsys.terminal'),
    environment: \Creagia\Redsys\Enums\Environment::Test,
);

$redsysNotification = new RedsysNotification($redsysClient);
$redsysNotification->setParametersFromResponse($_POST);

// If you need it, prior to checking response, you can use the decoded data from
// Redsys accessing the `NotificationParameters` object on `$redsysNotification->parameters`. 

try {
    $notificationData = $redsysNotification->checkResponse();
    // Authorised payment
} catch (DeniedRedsysPaymentNotification $e) {
    $errorMessage = $e->getMessage();
    // Denied payment with $errorMessage
}
```

<a name="custom-environments"></a>
### Custom environments

When creating a `RedsysClient` you can set the environment property to `Environment::Custom`.
In that case, you will also need to define the `customBaseUrl` propierty.

This feature enables you to use any mock or fake Redsys gateway to test you application locally, for example.

You can find an example on that on our other package [creagia/laravel-redsys](https://github.com/creagia/laravel-redsys), which
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
