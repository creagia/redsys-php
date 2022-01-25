<?php

namespace Creagia\Redsys;

use Creagia\Redsys\Enums\Currency;
use Creagia\Redsys\Enums\TransactionType;
use Creagia\Redsys\Support\RequestParameters;
use Creagia\Redsys\Support\Signature;
use Exception;
use JetBrains\PhpStorm\ArrayShape;

class RedsysRequest
{
    private RequestParameters $parameters;
    private string $signature;

    public function __construct(
        private RedsysClient $redsysClient
    ) {
    }

    public function getParameters(): array
    {
        return $this->parameters->toArray();
    }

    #[ArrayShape(['Ds_SignatureVersion' => "string", 'Ds_MerchantParameters' => "string", 'Ds_Signature' => "string"])]
    public function createPaymentRequest(
        float $amount,
        string $orderNumber,
        Currency $currency,
        TransactionType $transactionType,
        ?RequestParameters $requestParameters = null
    ): array {
        $this->parameters = $requestParameters ?? new RequestParameters();
        $this->parameters->amount = number_format(round($amount, 2) * 100, 0, '', '');
        $this->parameters->currency = $currency->value;
        $this->parameters->merchantCode = $this->redsysClient->merchantCode;
        $this->parameters->order = $orderNumber;
        $this->parameters->terminal = $this->redsysClient->terminal;
        $this->parameters->transactionType = $transactionType->value;

        $this->signature = Signature::calculateSignature(
            encodedParameters: $this->parameters->toEncodedString(),
            order: $this->parameters->order,
            secretKey: $this->redsysClient->secretKey,
        );

        return $this->getRequestFieldsArray();
    }

    #[ArrayShape(['Ds_SignatureVersion' => "string", 'Ds_MerchantParameters' => "string", 'Ds_Signature' => "string"])]
     public function getRequestFieldsArray(): array
     {
         return [
             'Ds_SignatureVersion' => $this->redsysClient->signatureVersion,
             'Ds_MerchantParameters' => $this->parameters->toEncodedString(),
             'Ds_Signature' => $this->signature,
         ];
     }

    public function getFormHtml(): string
    {
        if (empty($this->signature)) {
            throw new Exception('');
        }

        $formFields = $this->getRequestFieldsArray();

        return '
            <form action="' . $this->redsysClient->getBaseUrl() . '/realizarPago" method="post">
            <input type="hidden" name="Ds_SignatureVersion" value="' . $formFields['Ds_SignatureVersion'] . '"/>
            <input type="hidden" name="Ds_MerchantParameters" value="' . $formFields['Ds_MerchantParameters'] . '"/>
            <input type="hidden" name="Ds_Signature" value="' . $formFields['Ds_Signature'] . '"/>
            </form>
            <script>document.forms[0].submit();</script>
        ';
    }
}
