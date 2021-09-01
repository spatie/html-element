<?php

namespace Spatie\HtmlElement\Helpers;

class Arr
{
    public static function flatten(array $array): array
    {
        $flattened = [];

        foreach ($array as $element) {
            $flattened = array_merge(
                $flattened,
                is_array($element) ? static::flatten($element) : [$element]
            );
        }

        return $flattened;
    }

    public static function map(array $array, callable $mapper): array
    {
        return array_map($mapper, $array);
    }

    public static function flatMap(array $array, callable $mapper): array
    {
        return static::flatten(static::map($array, $mapper));
    }
}
