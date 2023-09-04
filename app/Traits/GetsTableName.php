<?php

namespace App\Traits;

trait GetsTableName
{
	public static function getTableName()
	{
		
		$model = new self();

		return $model->getTable();
	}
}