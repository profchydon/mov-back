<?php

namespace App\Traits;

trait ListsEnumValues
{
    public static function values()
    {
        return array_map(function ($case) {
            return $case->value;
        }, self::cases());
    }

    public static function keys()
    {
        return array_map(function ($case) {
            return $case->name;
        }, self::cases());
    }
}
