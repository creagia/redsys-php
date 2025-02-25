<?php

namespace Creagia\Redsys;

use Creagia\Redsys\Enums\CardBrand;
use Creagia\Redsys\Enums\CofInitial;
use Creagia\Redsys\Enums\ProcessedPayMethod;
use Creagia\Redsys\Support\RequestParameters;
use Creagia\Redsys\Support\Signature;
use DateTime;

class RedsysFakeGateway
{
    private $errorCode;
    private string $responseCode;

    public function __construct(
        private array $request,
        private string $secretKey
    ) {
    }

    public function getResponse(
        string $responseCode,
        $errorCode = null,
    ) {
        $this->responseCode = $responseCode;
        $this->errorCode = $errorCode;

        $merchantParameters = (array) json_decode(base64_decode(strtr($this->request['Ds_MerchantParameters'], '-_', '+/')));
        $signatureVersion = $this->request['Ds_SignatureVersion'];
        $inputParameters = RequestParameters::fromArray($merchantParameters);
        $responseParameters = base64_encode(json_encode($this->getResponseParameters($inputParameters)));
        $signature = Signature::calculateSignature(
            $responseParameters,
            $inputParameters->order,
            $this->secretKey,
        );

        $response = [
            'Ds_SignatureVersion' => $signatureVersion,
            'Ds_MerchantParameters' => $responseParameters,
            'Ds_Signature' => $signature,
        ];

        if ($errorCode) {
            $response['Ds_Error'] = $errorCode;
        }

        return $response;
    }

    private function getResponseParameters(RequestParameters $inputParameters)
    {
        $returnParameters = [
            'Ds_Date' => (new DateTime())->format('d/m/Y'),
            'Ds_Hour' => (new DateTime())->format('H:i'),
            'Ds_Amount' => $inputParameters->amountInCents,
            'Ds_Currency' => $inputParameters->currency,
            'Ds_Order' => $inputParameters->order,
            'Ds_MerchantCode' => $inputParameters->merchantCode,
            'Ds_Terminal' => $inputParameters->terminal,
            'Ds_Response' => $this->responseCode,
            'Ds_MerchantData' => $inputParameters->merchantData,
            'Ds_SecurePayment' => 1,
            'Ds_TransactionType' => $inputParameters->transactionType,
            'Ds_Card_Country' => 724, // https://unstats.un.org/unsd/methodology/m49/
            'Ds_AuthorisationCode' => $this->errorCode ? '' : mt_rand(100000, 999999),
            'Ds_ConsumerLanguage' => $inputParameters->consumerLanguage,
            'Ds_Card_Type' => 'C', // C,D
            'Ds_Card_Brand' => CardBrand::Visa,
//           'Ds_ErrorCode' => $this->errorCode,
//           'Ds_EMV3DS' => '',
//           'Ds_Excep_SCA' => '',
            'Ds_ProcessedPayMethod' => ProcessedPayMethod::VisaSecure,
        ];

        if (
            $inputParameters->cofIni === CofInitial::Yes
        ) {
            $returnParameters['Ds_Merchant_Cof_Txnid'] = '2006031152000';
            $returnParameters['Ds_Merchant_Identifier'] = '120c14ed9f7264383434fc1154559f1e2bcc2b1c';
            $returnParameters['Ds_Card_Number'] = '454881******0003';
            $returnParameters['Ds_ExpiryDate'] = '3412';
        }

        if (
            $inputParameters->cofIni === CofInitial::No
            && $inputParameters->merchantIdentifier
        ) {
            $returnParameters['Ds_Card_Number'] = '454881******0003';
            $returnParameters['Ds_Merchant_Cof_Txnid'] = '2006031152000';
        }

        return $returnParameters;
    }
}
