<?php

namespace Creagia\Redsys;

use Creagia\Redsys\Exceptions\DeniedRedsysPaymentNotification;
use Creagia\Redsys\Exceptions\InvalidRedsysNotification;
use Creagia\Redsys\ResponseCodes\ResponseCode;
use Creagia\Redsys\Support\NotificationParameters;
use Creagia\Redsys\Support\Signature;

class RedsysNotification
{
    public array $merchantParametersArray;
    public string $receivedSignature;
    public mixed $originalEncodedMerchantParameters;
    public NotificationParameters $parameters;

    public function __construct(
        private RedsysClient $redsysClient
    ) {
    }

    public function setParametersFromResponse(array $data): void
    {
        if (
            empty($data['Ds_SignatureVersion'])
            or empty($data['Ds_MerchantParameters'])
            or empty($data['Ds_Signature'])
        ) {
            throw new InvalidRedsysNotification('Redsys: invalid response from bank.');
        }

        $this->originalEncodedMerchantParameters = $data['Ds_MerchantParameters'];
        $this->merchantParametersArray = json_decode(urldecode(base64_decode(strtr($data['Ds_MerchantParameters'], '-_', '+/'))), true);
        $this->receivedSignature = $data['Ds_Signature'];
        $this->parameters = NotificationParameters::fromArray($this->merchantParametersArray);
    }

    public function checkResponse(): NotificationParameters
    {
        // Error SIS. Not necessary on redirection
//        if (isset($this->$this->merchantParametersArray['Ds_ErrorCode'])) {
//            throw new ErrorRedsysResponseNotification('Redsys: received error code ' . $this->$this->merchantParametersArray['Ds_ErrorCode']);
//        }

        $expectedSignature = Signature::calculateSignature(
            encodedParameters: $this->originalEncodedMerchantParameters,
            order: $this->parameters->order,
            secretKey: $this->redsysClient->secretKey,
        );

        if (strtr($this->receivedSignature, '-_', '+/') !== $expectedSignature) {
            throw new InvalidRedsysNotification("Redsys: invalid response. Signatures does not match.");
        }

        $responseCode = (int) $this->parameters->responseCode;

        if (! self::isAuthorisedCode($responseCode)) {
            throw new DeniedRedsysPaymentNotification(ResponseCode::fromCode($this->parameters->responseCode));
        }

        return $this->parameters;
    }

    public static function isAuthorisedCode(int $responseCode): bool
    {
        return ! ($responseCode > 99 and $responseCode !== 400 && $responseCode !== 900);
    }
}
