<?php

namespace Creagia\Redsys\Support\DataTransferObject;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class MapTo
{
    public function __construct(
        public string $name,
    ) {
    }
}
