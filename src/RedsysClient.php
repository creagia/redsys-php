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
        if ($this->environment === Environment::Production) {
            return 'https://sis.redsys.es/sis';
        }

        if ($this->environment === Environment::Test) {
            return 'https://sis-t.redsys.es:25443/sis';
        }

        if ($this->environment === Environment::Custom) {
            return $this->customBaseUrl;
        }

        throw new \Exception('Redsys undefined environment');
    }
}
