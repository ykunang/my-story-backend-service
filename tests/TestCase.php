<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $header = ['accept' => 'application/json'];

    public function setUp(): void {
        parent::setUp();
        Artisan::call('migrate:fresh');
    }
}
