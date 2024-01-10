<?php

namespace App\Traits;

trait GetsTableName
{
    public static function getTableName()
    {
        $model = new static();

        return $model->getTable();
    }
}
