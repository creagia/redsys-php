<?php

namespace Creagia\Redsys\Support\DataTransferObject\Casters;

interface Caster
{
    public function cast(mixed $value): mixed;
}
