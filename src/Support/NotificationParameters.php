<?php

namespace Creagia\Redsys\Support;

use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\DataTransferObject;

class NotificationParameters extends DataTransferObject
{
    #[MapTo('DS_DATE')]
    public ?string $date;

    #[MapTo('DS_HOUR')]
    public ?string $hour;

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
    public ?int $cardBrand;

    #[MapTo('DS_CARD_NUMBER')]
    public ?string $cardNumber;

    #[MapTo('DS_EXPIRYDATE')]
    public ?int $cardExpiryDate;

    #[MapTo('DS_MERCHANT_IDENTIFIER')]
    public ?string $merchantIdentifier;

    #[MapTo('DS_ERRORCODE')]
    public ?string $errorCode;

    #[MapTo('DS_URLPAGO2FASES')]
    public ?string $payGoldPayUrl;

    #[MapTo('DS_SIGNATURE')]
    public ?string $responseSignature;

    #[MapTo('DS_DCC')]
    public ?string $dcc;

    #[MapTo('DS_EMV3DS')]
    public ?string $emv3;

    #[MapTo('DS_CARD_PSD2')]
    public ?string $psd2CardAffected;

    #[MapTo('DS_EXCEP_SCA')]
    public ?string $scaException;

    #[MapTo('DS_PROCESSEDPAYMETHOD')]
    public ?string $cofProcessedPayMethod;

    #[MapTo('DS_MERCHANT_COF_TXNID')]
    public ?string $cofTransactionId;

    #[MapTo('DS_AMOUNT_DCC')]
    public ?string $dccAmount;

    #[MapTo('DS_AMOUNT_EURO')]
    public ?string $dccEuroAmount;

    #[MapTo('DS_CURRENCY_DCC')]
    public ?string $dccCurrency;

    #[MapTo('RTS')]
    public ?string $rts;

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
}
