<?php

namespace Creagia\Redsys\Support;

class PostRequestError
{
    public function __construct(
        public string $code,
        public ?string $message,
        public array $responseParameters = [],
    ) {
    }
}
