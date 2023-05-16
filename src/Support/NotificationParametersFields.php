<?php

namespace Creagia\Redsys\Support;

class NotificationParametersFields
{
    public static $relation = [
        'DS_DATE' => 'date',
        'DS_HOUR' => 'hour',
        'DS_AMOUNT' => 'amount',
        'DS_CURRENCY' => 'currency',
        'DS_ORDER' => 'order',
        'DS_MERCHANTCODE' => 'merchantCode',
        'DS_TERMINAL' => 'terminal',
        'DS_RESPONSE' => 'responseCode',
        'DS_MERCHANTDATA' => 'merchantData',
        'DS_SECUREPAYMENT' => 'securePayment',
        'DS_TRANSACTIONTYPE' => 'transactionType',
        'DS_CARD_COUNTRY' => 'cardCountry',
        'DS_AUTHORISATIONCODE' => 'responseAuthorisationCode',
        'DS_CONSUMERLANGUAGE' => 'consumerLanguage',
        'DS_CARD_TYPE' => 'cardType',
        'DS_CARD_BRAND' => 'cardBrand',
        'DS_CARD_NUMBER' => 'cardNumber',
        'DS_EXPIRYDATE' => 'cardExpiryDate',
        'DS_MERCHANT_IDENTIFIER' => 'merchantIdentifier',
        'DS_URLPAGO2FASES' => 'payGoldPayUrl',
        'DS_SIGNATURE' => 'responseSignature',
        'DS_DCC' => 'dcc',
        'DS_EMV3DS' => 'emv3',
        'DS_CARD_PSD2' => 'psd2CardAffected',
        'DS_EXCEP_SCA' => 'scaException',
        'DS_PROCESSEDPAYMETHOD' => 'cofProcessedPayMethod',
        'DS_MERCHANT_COF_TXNID' => 'cofTransactionId',
        'DS_AMOUNT_DCC' => 'dccAmount',
        'DS_AMOUNT_EURO' => 'dccEuroAmount',
        'DS_CURRENCY_DCC' => 'dccCurrency',
        'RTS' => 'rts',
    ];
}
