<?php

namespace App\Traits;

trait DTOToArray
{
    public function toArray(): array
    {
        $values = [];
        foreach ($this as $key => $value) {
            $values[$key] = $value;
        }

        return $values;
    }

    public function toSynthensizedArray(): array
    {
        $values = [];
        foreach ($this as $key => $value) {
            if (!empty($value)) {
                $values[$key] = $value;
            }
        }

        return $values;
    }
}
