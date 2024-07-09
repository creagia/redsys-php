<?php

namespace Creagia\Redsys\Support;

use Countable;
use Stringable;

class Arr
{
    /**
     * Determine if the given value is "blank".
     * https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/helpers.php#L49
     *
     * @phpstan-assert-if-false !=null|'' $value
     *
     * @phpstan-assert-if-true !=numeric|bool $value
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function blank(mixed $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        if ($value instanceof Stringable) {
            return trim((string) $value) === '';
        }

        return empty($value);
    }

    /**
     * Determine if a value is "filled".
     * https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/helpers.php#L164
     *
     * @phpstan-assert-if-true !=null|'' $value
     *
     * @phpstan-assert-if-false !=numeric|bool $value
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function filled(mixed $value): bool
    {
        return ! self::blank($value);
    }
}
