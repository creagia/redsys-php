<?php

namespace Creagia\Redsys\Support;

use Creagia\Redsys\Support\DataTransferObject\DataTransferObject;
use Creagia\Redsys\Support\DataTransferObject\MapFrom;

class NotificationParameters extends DataTransferObject
{
    public function __construct(
        #[MapFrom('DS_AMOUNT')]
        public int $amount,

        #[MapFrom('DS_CURRENCY')]
        public int $currency,

        #[MapFrom('DS_ORDER')]
        public string $order,

        #[MapFrom('DS_MERCHANTCODE')]
        public string $merchantCode,

        #[MapFrom('DS_TERMINAL')]
        public int $terminal,

        #[MapFrom('DS_RESPONSE')]
        public string $responseCode,

        #[MapFrom('DS_SECUREPAYMENT')]
        public string $securePayment,

        #[MapFrom('DS_DATE')]
        public ?string $date = null,

        #[MapFrom('DS_HOUR')]
        public ?string $hour = null,

        #[MapFrom('DS_MERCHANTDATA')]
        public ?string $merchantData = null,

        #[MapFrom('DS_TRANSACTIONTYPE')]
        public ?string $transactionType = null,

        #[MapFrom('DS_CARD_COUNTRY')]
        public ?string $cardCountry = null,

        #[MapFrom('DS_AUTHORISATIONCODE')]
        public ?string $responseAuthorisationCode = null,

        #[MapFrom('DS_CONSUMERLANGUAGE')]
        public ?string $consumerLanguage = null,

        #[MapFrom('DS_CARD_TYPE')]
        public ?string $cardType = null,

        #[MapFrom('DS_CARD_BRAND')]
        public ?int $cardBrand = null,

        #[MapFrom('DS_CARD_NUMBER')]
        public ?string $cardNumber = null,

        #[MapFrom('DS_EXPIRYDATE')]
        public ?int $cardExpiryDate = null,

        #[MapFrom('DS_MERCHANT_IDENTIFIER')]
        public ?string $merchantIdentifier = null,

        #[MapFrom('DS_ERRORCODE')]
        public ?string $errorCode = null,

        #[MapFrom('DS_URLPAGO2FASES')]
        public ?string $payGoldPayUrl = null,

        #[MapFrom('DS_SIGNATURE')]
        public ?string $responseSignature = null,

        #[MapFrom('DS_DCC')]
        public ?string $dcc = null,

        #[MapFrom('DS_EMV3DS')]
        public ?string $emv3 = null,

        #[MapFrom('DS_CARD_PSD2')]
        public ?string $psd2CardAffected = null,

        #[MapFrom('DS_EXCEP_SCA')]
        public ?string $scaException = null,

        #[MapFrom('DS_PROCESSEDPAYMETHOD')]
        public ?string $cofProcessedPayMethod = null,

        #[MapFrom('DS_MERCHANT_COF_TXNID')]
        public ?string $cofTransactionId = null,

        #[MapFrom('DS_AMOUNT_DCC')]
        public ?string $dccAmount = null,

        #[MapFrom('DS_AMOUNT_EURO')]
        public ?string $dccEuroAmount = null,

        #[MapFrom('DS_CURRENCY_DCC')]
        public ?string $dccCurrency = null,

        #[MapFrom('RTS')]
        public ?string $rts = null,

        #[MapFrom('DS_ECI')]
        public ?string $eci = null,

        #[MapFrom('DS_RESPONSE_DESCRIPTION')]
        public ?string $responseDescription = null,
    ) {
    }

    public function toArray(): array
    {
        return array_filter(parent::toArray());
    }
}
