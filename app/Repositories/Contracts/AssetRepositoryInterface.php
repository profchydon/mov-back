<?php

namespace App\Repositories\Contracts;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    public function getCheckouts();

    public function getArchived();
}
