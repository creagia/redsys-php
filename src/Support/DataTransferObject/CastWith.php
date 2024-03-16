<?php

namespace Creagia\Redsys\Support\DataTransferObject;

use Attribute;
use Creagia\Redsys\Support\DataTransferObject\Casters\Caster;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class CastWith
{
    public array $args;

    public function __construct(
        public string $casterClass,
        mixed ...$args
    ) {
        if (! is_subclass_of($this->casterClass, Caster::class)) {
            throw new \Error('Invalid caster class ' . $this->casterClass);
        }

        $this->args = $args;
    }
}
