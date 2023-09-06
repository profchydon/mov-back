<?php

namespace App\Repositories;

interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    function checkouts();

    function archived();
}