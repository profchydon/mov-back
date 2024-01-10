<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use LazilyRefreshDatabase;

    const BASE = 'https://core-api-dev.rayda.co/api/v2';

    public static function fullLink($link): string
    {
        return self::BASE . $link;
    }
}
