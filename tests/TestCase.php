<?php

namespace Tests;

use Illuminate\Foundation\Testing\{TestCase as BaseTestCase, DatabaseMigrations};

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
}
