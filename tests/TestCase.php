<?php

namespace Tests;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $header = ['accept' => 'application/json'];

    public function setUp(): void {
        parent::setUp();
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');

        $this->header['x-api-key']= getenv('API_KEY');
        /**
         * remove log image
         */
        $files = new Filesystem();
        $files->cleanDirectory(storage_path('app/public/stories'));
    }
}
