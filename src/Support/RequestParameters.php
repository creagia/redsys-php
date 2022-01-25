<?php

namespace Creagia\Redsys\Support;

use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\DataTransferObject;

class RequestParameters extends DataTransferObject
{
    #[MapTo('DS_MERCHANT_AMOUNT')]
    public ?int $amount;

    #[MapTo('DS_MERCHANT_AUTHORISATIONCODE')]
    public ?string $authorisationCode;

    #[MapTo('DS_MERCHANT_COF_INI')]
    public ?string $cofIni;

    #[MapTo('DS_MERCHANT_COF_TXNID')]
    public ?string $cofTxnId;

    #[MapTo('DS_MERCHANT_COF_TYPE')]
    public ?string $cofType;

    #[MapTo('DS_MERCHANT_CONSUMERLANGUAGE')]
    public ?string $consumerLanguage;

    #[MapTo('DS_MERCHANT_CURRENCY')]
    public ?int $currency;

    #[MapTo('DS_MERCHANT_CVV2')]
    public ?string $cvv2;

    #[MapTo('DS_MERCHANT_DIRECTPAYMENT')]
    public ?string $directPayment;

    #[MapTo('DS_MERCHANT_EMV3DS')]
    public ?string $emv3ds;

    #[MapTo('DS_MERCHANT_EXPIRYDATE')]
    public ?string $expiryDate;

    #[MapTo('DS_MERCHANT_GROUP')]
    public ?string $group;

    #[MapTo('DS_MERCHANT_IDENTIFIER')]
    public ?string $identifier;

    #[MapTo('DS_MERCHANT_IDOPER')]
    public ?string $idOper;

    #[MapTo('DS_MERCHANT_MERCHANTCODE')]
    public ?string $merchantCode;

    #[MapTo('DS_MERCHANT_MERCHANTDATA')]
    public ?string $merchantData;

    #[MapTo('DS_MERCHANT_MERCHANTNAME')]
    public ?string $merchantName;

    #[MapTo('DS_MERCHANT_MERCHANTURL')]
    public ?string $merchantUrl;

    #[MapTo('DS_MERCHANT_ORDER')]
    public ?string $order;

    #[MapTo('DS_MERCHANT_PAN')]
    public ?string $pan;

    #[MapTo('DS_MERCHANT_PAYMETHODS')]
    public ?string $payMethods;

    #[MapTo('DS_MERCHANT_PRODUCTDESCRIPTION')]
    public ?string $productDescription;

    #[MapTo('DS_MERCHANT_TAX_REFERENCE')]
    public ?string $taxReference;

    #[MapTo('DS_MERCHANT_TERMINAL')]
    public ?int $terminal;

    #[MapTo('DS_MERCHANT_TITULAR')]
    public ?string $titular;

    #[MapTo('DS_MERCHANT_TRANSACTIONDATE')]
    public ?string $transactionDate;

    #[MapTo('DS_MERCHANT_TRANSACTIONTYPE')]
    public ?string $transactionType;

    #[MapTo('DS_MERCHANT_URLOK')]
    public ?string $urlOk;

    #[MapTo('DS_MERCHANT_URLKO')]
    public ?string $urlKo;

    #[MapTo('DS_XPAYDATA')]
    public ?string $xpayData;

    #[MapTo('DS_XPAYORIGEN')]
    public ?string $xpayOrigen;

    #[MapTo('DS_XPAYTYPE')]
    public ?string $xpayType;

    #[MapTo('DS_MERCHANT_SHIPPINGADDRESSPYP')]
    public ?string $shippingAddressPyp;

    #[MapTo('DS_MERCHANT_MERCHANTDESCRIPTOR')]
    public ?string $merchantDescriptor;

    #[MapTo('DS_MERCHANT_PERSOCODE')]
    public ?string $persoCode;

    #[MapTo('DS_MERCHANT_MATCHINGDATA')]
    public ?string $matchingData;

    #[MapTo('DS_ACQUIRER_IDENTIFIER')]
    public ?string $acquirerIdentifier;

    #[MapTo('DS_MERCHANT_MPIEXTERNAL')]
    public ?string $mpiExternal;

    #[MapTo('DS_MERCHANT_CUSTOMER_MOBILE')]
    public ?string $customerMobile;

    #[MapTo('DS_MERCHANT_CUSTOMER_MAIL')]
    public ?string $customerMail;

    #[MapTo('DS_MERCHANT_P2F_EXPIRYDATE')]
    public ?string $p2fExpiryDate;

    #[MapTo('DS_MERCHANT_CUSTOMER_SMS_TEXT')]
    public ?string $customerSmsText;

    #[MapTo('DS_MERCHANT_P2F_XMLDATA')]
    public ?string $p2fXmlData;

    #[MapTo('DS_MERCHANT_DCC')]
    public ?string $dcc;

    #[MapTo('DS_MERCHANT_EXCEP_SCA')]
    public ?string $excepSca;

    #[MapTo('DS_MERCHANT_OTA')]
    public ?string $ota;

    public static function fromArray(array $parameters): RequestParameters
    {
        $castedParameters = [];
        foreach ($parameters as $key => $value) {
            $castedParameters[RequestParametersFields::$relation[strtoupper($key)] ?? $key] = $value;
        }

        return new RequestParameters(...$castedParameters);
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
