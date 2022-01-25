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
        'DS_ERRORCODE' => 'errorCode',
        'DS_EMV3DS' => 'EMV3DS',
        'DS_EXCEP_SCA' => 'excepSCA',
        'DS_PROCESSEDPAYMETHOD' => 'processedPayMethod',
    ];
}
