<?php

namespace Creagia\Redsys\Support;

use Spatie\DataTransferObject\DataTransferObject;

class NotificationParameters extends DataTransferObject
{
    #[MapTo('DS_DATE')]
    public string $date;

    #[MapTo('DS_HOUR')]
    public string $hour;

    #[MapTo('DS_AMOUNT')]
    public int $amount;

    #[MapTo('DS_CURRENCY')]
    public int $currency;

    #[MapTo('DS_ORDER')]
    public string $order;

    #[MapTo('DS_MERCHANTCODE')]
    public string $merchantCode;

    #[MapTo('DS_TERMINAL')]
    public int $terminal;

    #[MapTo('DS_RESPONSE')]
    public string $responseCode;

    #[MapTo('DS_MERCHANTDATA')]
    public ?string $merchantData;

    #[MapTo('DS_SECUREPAYMENT')]
    public string $securePayment;

    #[MapTo('DS_TRANSACTIONTYPE')]
    public ?string $transactionType;

    #[MapTo('DS_CARD_COUNTRY')]
    public ?string $cardCountry;

    #[MapTo('DS_AUTHORISATIONCODE')]
    public ?string $responseAuthorisationCode;

    #[MapTo('DS_CONSUMERLANGUAGE')]
    public ?string $consumerLanguage;

    #[MapTo('DS_CARD_TYPE')]
    public ?string $cardType;

    #[MapTo('DS_CARD_BRAND')]
    public ?string $cardBrand;

    #[MapTo('DS_ERRORCODE')]
    public ?string $errorCode;

    #[MapTo('DS_EMV3DS')]
    public ?string $EMV3DS;

    #[MapTo('DS_EXCEP_SCA')]
    public ?string $excepSCA;

    #[MapTo('DS_PROCESSEDPAYMETHOD')]
    public ?string $processedPayMethod;

    public static function fromArray(array $parameters): NotificationParameters
    {
        $castedParameters = [];
        foreach ($parameters as $key => $value) {
            $castedParameters[NotificationParametersFields::$relation[strtoupper($key)] ?? $key] = $value;
        }

        return new NotificationParameters(...$castedParameters);
    }

    public function toEncodedString(): string
    {
        return base64_encode(json_encode($this->toArray()));
    }

    public function toArray(): array
    {
        return array_filter(parent::toArray());
    }

    public function getAmount(): float
    {
        return (float) $this->amount / 100;
    }
}
