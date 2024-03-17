<?php

namespace Creagia\Redsys\Support\DataTransferObject;

use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{
    public static function caseSensitive(): bool
    {
        return false;
    }

    public function toArray(): array
    {
        $data = [];

        $class = new ReflectionClass(static::class);

        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $mapToAttribute = $property->getAttributes(MapTo::class);
            $name = count($mapToAttribute) ? $mapToAttribute[0]->newInstance()->name : $property->getName();

            $data[$name] = $property->getValue($this);
        }

        return $data;
    }

    public static function fromArray(array $parameters): static
    {
        $normalizedParameters = [];
        $propertiesName = [];
        $propertiesCast = [];
        $class = new ReflectionClass(static::class);
        $properties = $class->getProperties();

        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $mapFromAttribute = $property->getAttributes(MapFrom::class);
            $castWithAttribute = $property->getAttributes(CastWith::class);
            $name = count($mapFromAttribute) ? $mapFromAttribute[0]->newInstance()->name : $property->getName();
            if (count($castWithAttribute)) {
                $propertiesCast[$property->getName()] = $castWithAttribute[0]->newInstance();
            }
            $propertiesName[self::caseSensitive() ? $name : strtoupper($name)] = $property->name;
        }

        foreach ($parameters as $key => $value) {
            $caseKey = self::caseSensitive() ? $key : strtoupper($key);
            $normalizedParameters[$propertiesName[$caseKey] ?? $key] = self::getCastedValue($value, $propertiesCast[$propertiesName[$caseKey]] ?? null);
        }

        return new static(...$normalizedParameters);
    }

    private static function getCastedValue($value, $attribute): mixed
    {

        if (is_null($attribute)) {
            return $value;
        }

        return (new $attribute->casterClass($attribute->args[0]))->cast($value);
    }
}
