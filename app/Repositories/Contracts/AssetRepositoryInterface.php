<?php

namespace App\Repositories\Contracts;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    function getCheckouts();

    function getArchived();
}