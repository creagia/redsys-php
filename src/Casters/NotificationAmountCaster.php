<?php

namespace Creagia\Redsys\Casters;

use Spatie\DataTransferObject\Caster;

class NotificationAmountCaster implements Caster
{
    public function cast(mixed $value): float
    {
        return floatval($value / 100);
    }
}
