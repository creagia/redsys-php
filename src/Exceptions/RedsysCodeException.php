<?php

namespace Creagia\Redsys\Exceptions;

class RedsysCodeException extends \Exception
{
    public string $redsysCode;

    public function __construct(string $redsysCode, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->redsysCode = $redsysCode;
        parent::__construct($message, $code, $previous);
    }
}
