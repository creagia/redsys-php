<?php

namespace Creagia\Redsys;

use Creagia\Redsys\Enums\CofInitial;
use Creagia\Redsys\Enums\CofType;
use Creagia\Redsys\Enums\DirectPayment;
use Creagia\Redsys\Enums\MerchantIdentifier;
use Creagia\Redsys\Exceptions\DeniedRedsysPaymentResponseException;
use Creagia\Redsys\Exceptions\ErrorRedsysResponseException;
use Creagia\Redsys\Exceptions\InvalidRedsysResponseException;
use Creagia\Redsys\Exceptions\RedsysCodeException;
use Creagia\Redsys\Support\NotificationParameters;
use Creagia\Redsys\Support\PostRequestError;
use Creagia\Redsys\Support\RequestParameters;
use Creagia\Redsys\Support\Signature;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use JetBrains\PhpStorm\ArrayShape;

class RedsysRequest
{
    private RedsysClient $redsysClient;
    private RequestParameters $parameters;
    private string $signature;

    public static function create(
        RedsysClient $redsysClient,
        RequestParameters $requestParameters
    ): static {
        $request = new RedsysRequest();
        $request->redsysClient = $redsysClient;
        $request->parameters = $requestParameters;
        $request->parameters->merchantCode = $request->redsysClient->merchantCode;
        $request->parameters->terminal = $request->redsysClient->terminal;

        return $request;
    }

    public function requestingCardToken(
        CofType $cofType,
    ): static {
        $this->parameters->cofType = $cofType;
        $this->parameters->cofIni = CofInitial::Yes;
        $this->parameters->merchantIdentifier = MerchantIdentifier::InitialPetition->value;

        return $this;
    }

    public function usingCardToken(
        CofType $cofType,
        string $cofTransactionId,
        string $merchantIdentifier,
    ): static {
        $this->parameters->cofType = $cofType;
        $this->parameters->cofIni = CofInitial::No;
        $this->parameters->cofTransactionId = $cofTransactionId;
        $this->parameters->merchantIdentifier = $merchantIdentifier;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters->toArray();
    }

    #[ArrayShape(['Ds_SignatureVersion' => "string", 'Ds_MerchantParameters' => "string", 'Ds_Signature' => "string"])]
    public function getRequestFieldsArray(): array
    {
        $this->signature = Signature::calculateSignature(
            encodedParameters: $this->parameters->toEncodedString(),
            order: $this->parameters->order,
            secretKey: $this->redsysClient->secretKey,
        );

        return [
            'Ds_SignatureVersion' => $this->redsysClient->signatureVersion,
            'Ds_MerchantParameters' => $this->parameters->toEncodedString(),
            'Ds_Signature' => $this->signature,
        ];
    }

    public function getRedirectFormHtml(): string
    {
        $formFields = $this->getRequestFieldsArray();

        return <<<HTML
            <form action="{$this->redsysClient->getBaseUrl()}/realizarPago" method="post">
            <input type="hidden" name="Ds_SignatureVersion" value="{$formFields['Ds_SignatureVersion']}"/>
            <input type="hidden" name="Ds_MerchantParameters" value="{$formFields['Ds_MerchantParameters']}"/>
            <input type="hidden" name="Ds_Signature" value="{$formFields['Ds_Signature']}"/>
            </form>
            <script>document.forms[0].submit();</script>
        HTML;
    }

    /**
     * @throws GuzzleException
     * @throws InvalidRedsysResponseException
     */
    public function sendPostRequest(): RedsysResponse|PostRequestError
    {
        $client = new Client();
        $this->parameters->directPayment = DirectPayment::True;

        $request = new Request(
            'POST',
            $this->redsysClient->getRestBaseUrl() . '/trataPeticionREST',
            ["Content-Type" => 'application/json'],
            json_encode($this->getRequestFieldsArray())
        );

        $response = $client->send($request);
        $responseContents = (array) json_decode($response->getBody()->getContents());
        $redsysResponse = new RedsysResponse($this->redsysClient);

        try {
            $redsysResponse->setParametersFromResponse($responseContents);

            return $redsysResponse;
        } catch (RedsysCodeException $exception) {
            return new PostRequestError(
                code: $exception->redsysCode,
                message: $exception->getMessage(),
                responseParameters: $responseContents,
            );
        }
    }
}
