<?php

namespace Creagia\Redsys\Support;

use Creagia\Redsys\Enums\CofInitial;
use Creagia\Redsys\Enums\CofType;
use Creagia\Redsys\Enums\ConsumerLanguage;
use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\DirectPayment;
use Creagia\Redsys\Enums\PayMethod;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\Support\DataTransferObject\Casters\EnumCaster;
use Creagia\Redsys\Support\DataTransferObject\CastWith;
use Creagia\Redsys\Support\DataTransferObject\DataTransferObject;
use Creagia\Redsys\Support\DataTransferObject\MapFrom;
use Creagia\Redsys\Support\DataTransferObject\MapTo;

class RequestParameters extends DataTransferObject
{
    public function __construct(
        #[MapTo('DS_MERCHANT_AMOUNT')]
        #[MapFrom('DS_MERCHANT_AMOUNT')]
        public int $amountInCents,

        #[MapTo('DS_MERCHANT_TRANSACTIONTYPE')]
        #[MapFrom('DS_MERCHANT_TRANSACTIONTYPE')]
        #[CastWith(EnumCaster::class, TransactionType::class)]
        public TransactionType $transactionType,

        #[MapTo('DS_MERCHANT_CURRENCY')]
        #[MapFrom('DS_MERCHANT_CURRENCY')]
        #[CastWith(EnumCaster::class, Currency::class)]
        public Currency $currency,

        #[MapTo('DS_MERCHANT_ORDER')]
        #[MapFrom('DS_MERCHANT_ORDER')]
        public ?string $order = null,

        #[MapTo('DS_MERCHANT_AUTHORISATIONCODE')]
        #[MapFrom('DS_MERCHANT_AUTHORISATIONCODE')]
        public ?string $authorisationCode = null,

        #[MapTo('DS_MERCHANT_COF_INI')]
        #[MapFrom('DS_MERCHANT_COF_INI')]
        #[CastWith(EnumCaster::class, CofInitial::class)]
        public ?CofInitial $cofIni = null,

        #[MapTo('DS_MERCHANT_COF_TXNID')]
        #[MapFrom('DS_MERCHANT_COF_TXNID')]
        public ?string $cofTransactionId = null,

        #[MapTo('DS_MERCHANT_COF_TYPE')]
        #[MapFrom('DS_MERCHANT_COF_TYPE')]
        #[CastWith(EnumCaster::class, CofType::class)]
        public ?CofType $cofType = null,

        #[MapTo('DS_MERCHANT_CONSUMERLANGUAGE')]
        #[MapFrom('DS_MERCHANT_CONSUMERLANGUAGE')]
        #[CastWith(EnumCaster::class, ConsumerLanguage::class)]
        public ?ConsumerLanguage $consumerLanguage = null,

        #[MapTo('DS_MERCHANT_CVV2')]
        #[MapFrom('DS_MERCHANT_CVV2')]
        public ?string $cvv2 = null,

        #[MapTo('DS_MERCHANT_DIRECTPAYMENT')]
        #[MapFrom('DS_MERCHANT_DIRECTPAYMENT')]
        #[CastWith(EnumCaster::class, DirectPayment::class)]
        public ?DirectPayment $directPayment = null,

        #[MapTo('DS_MERCHANT_EMV3DS')]
        #[MapFrom('DS_MERCHANT_EMV3DS')]
        public ?string $emv3ds = null,

        #[MapTo('DS_MERCHANT_EXPIRYDATE')]
        #[MapFrom('DS_MERCHANT_EXPIRYDATE')]
        public ?string $expiryDate = null,

        #[MapTo('DS_MERCHANT_GROUP')]
        #[MapFrom('DS_MERCHANT_GROUP')]
        public ?string $group = null,

        #[MapTo('DS_MERCHANT_IDENTIFIER')]
        #[MapFrom('DS_MERCHANT_IDENTIFIER')]
        public ?string $merchantIdentifier = null,

        #[MapTo('DS_MERCHANT_IDOPER')]
        #[MapFrom('DS_MERCHANT_IDOPER')]
        public ?string $idOper = null,

        #[MapTo('DS_MERCHANT_MERCHANTCODE')]
        #[MapFrom('DS_MERCHANT_MERCHANTCODE')]
        public ?string $merchantCode = null,

        #[MapTo('DS_MERCHANT_MERCHANTDATA')]
        #[MapFrom('DS_MERCHANT_MERCHANTDATA')]
        public ?string $merchantData = null,

        #[MapTo('DS_MERCHANT_MERCHANTNAME')]
        #[MapFrom('DS_MERCHANT_MERCHANTNAME')]
        public ?string $merchantName = null,

        #[MapTo('DS_MERCHANT_MERCHANTURL')]
        #[MapFrom('DS_MERCHANT_MERCHANTURL')]
        public ?string $merchantUrl = null,

        #[MapTo('DS_MERCHANT_PAN')]
        #[MapFrom('DS_MERCHANT_PAN')]
        public ?string $pan = null,

        #[MapTo('DS_MERCHANT_PAYMETHODS')]
        #[MapFrom('DS_MERCHANT_PAYMETHODS')]
        #[CastWith(EnumCaster::class, PayMethod::class)]
        public ?PayMethod $payMethods = null,

        #[MapTo('DS_MERCHANT_PRODUCTDESCRIPTION')]
        #[MapFrom('DS_MERCHANT_PRODUCTDESCRIPTION')]
        public ?string $productDescription = null,

        #[MapTo('DS_MERCHANT_TAX_REFERENCE')]
        #[MapFrom('DS_MERCHANT_TAX_REFERENCE')]
        public ?string $taxReference = null,

        #[MapTo('DS_MERCHANT_TERMINAL')]
        #[MapFrom('DS_MERCHANT_TERMINAL')]
        public ?int $terminal = null,

        #[MapTo('DS_MERCHANT_TITULAR')]
        #[MapFrom('DS_MERCHANT_TITULAR')]
        public ?string $titular = null,

        #[MapTo('DS_MERCHANT_TRANSACTIONDATE')]
        #[MapFrom('DS_MERCHANT_TRANSACTIONDATE')]
        public ?string $transactionDate = null,

        #[MapTo('DS_MERCHANT_URLOK')]
        #[MapFrom('DS_MERCHANT_URLOK')]
        public ?string $urlOk = null,

        #[MapTo('DS_MERCHANT_URLKO')]
        #[MapFrom('DS_MERCHANT_URLKO')]
        public ?string $urlKo = null,

        #[MapTo('DS_XPAYDATA')]
        #[MapFrom('DS_XPAYDATA')]
        public ?string $xpayData = null,

        #[MapTo('DS_XPAYORIGEN')]
        #[MapFrom('DS_XPAYORIGEN')]
        public ?string $xpayOrigen = null,

        #[MapTo('DS_XPAYTYPE')]
        #[MapFrom('DS_XPAYTYPE')]
        public ?string $xpayType = null,

        #[MapTo('DS_MERCHANT_SHIPPINGADDRESSPYP')]
        #[MapFrom('DS_MERCHANT_SHIPPINGADDRESSPYP')]
        public ?string $shippingAddressPyp = null,

        #[MapTo('DS_MERCHANT_MERCHANTDESCRIPTOR')]
        #[MapFrom('DS_MERCHANT_MERCHANTDESCRIPTOR')]
        public ?string $merchantDescriptor = null,

        #[MapTo('DS_MERCHANT_PERSOCODE')]
        #[MapFrom('DS_MERCHANT_PERSOCODE')]
        public ?string $persoCode = null,

        #[MapTo('DS_MERCHANT_MATCHINGDATA')]
        #[MapFrom('DS_MERCHANT_MATCHINGDATA')]
        public ?string $matchingData = null,

        #[MapTo('DS_ACQUIRER_IDENTIFIER')]
        #[MapFrom('DS_ACQUIRER_IDENTIFIER')]
        public ?string $acquirerIdentifier = null,

        #[MapTo('DS_MERCHANT_MPIEXTERNAL')]
        #[MapFrom('DS_MERCHANT_MPIEXTERNAL')]
        public ?string $mpiExternal = null,

        #[MapTo('DS_MERCHANT_CUSTOMER_MOBILE')]
        #[MapFrom('DS_MERCHANT_CUSTOMER_MOBILE')]
        public ?string $customerMobile = null,

        #[MapTo('DS_MERCHANT_CUSTOMER_MAIL')]
        #[MapFrom('DS_MERCHANT_CUSTOMER_MAIL')]
        public ?string $customerMail = null,

        #[MapTo('DS_MERCHANT_P2F_EXPIRYDATE')]
        #[MapFrom('DS_MERCHANT_P2F_EXPIRYDATE')]
        public ?string $p2fExpiryDate = null,

        #[MapTo('DS_MERCHANT_CUSTOMER_SMS_TEXT')]
        #[MapFrom('DS_MERCHANT_CUSTOMER_SMS_TEXT')]
        public ?string $customerSmsText = null,

        #[MapTo('DS_MERCHANT_P2F_XMLDATA')]
        #[MapFrom('DS_MERCHANT_P2F_XMLDATA')]
        public ?string $p2fXmlData = null,

        #[MapTo('DS_MERCHANT_DCC')]
        #[MapFrom('DS_MERCHANT_DCC')]
        public ?string $dcc = null,

        #[MapTo('DS_MERCHANT_EXCEP_SCA')]
        #[MapFrom('DS_MERCHANT_EXCEP_SCA')]
        public ?string $excepSca = null,

        #[MapTo('DS_MERCHANT_OTA')]
        #[MapFrom('DS_MERCHANT_OTA')]
        public ?string $ota = null,
    ) {
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
