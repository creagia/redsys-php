<?php

namespace Creagia\Redsys\Casters;

use Spatie\DataTransferObject\Caster;

class EnumCaster implements Caster
{
    public function __construct(
        private array $types,
        private string $class,
    )
    {
    }

    public function cast(mixed $value): mixed
    {
        if ($value instanceof $this->class) {
            return $value;
        }

        return $this->class::from($value);
    }
}
