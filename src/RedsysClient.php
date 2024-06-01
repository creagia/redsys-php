<?php

namespace Creagia\Redsys;

use Creagia\Redsys\Enums\Environment;

class RedsysClient
{
    public $signatureVersion = 'HMAC_SHA256_V1';

    public function __construct(
        public int $merchantCode,
        public string $secretKey,
        public int $terminal,
        public Environment $environment,
        public ?string $customBaseUrl = null,
    ) {
        if ($this->environment === Environment::Custom) {
            if (! $this->customBaseUrl) {
                throw new \Exception('Redsys custom environment without custom URL defined');
            }
        }
    }

    public function getBaseUrl(): string
    {
        return match($this->environment) {
            Environment::Production => 'https://sis.redsys.es/sis',
            Environment::Test => 'https://sis-t.redsys.es:25443/sis',
            Environment::Custom => $this->customBaseUrl,
            default => throw new \Exception('Redsys undefined environment'),
        };
    }

    public function getRestBaseUrl(): string
    {
        return match ($this->environment) {
            Environment::Production => 'https://sis.redsys.es/sis/rest',
            Environment::Test => 'https://sis-t.redsys.es:25443/sis/rest',
            Environment::Custom => $this->customBaseUrl,
            default => throw new \Exception('Redsys undefined environment'),
        };
    }
}
