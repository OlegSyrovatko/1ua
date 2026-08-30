<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\ServiceProvider;
use App\Filesystem\Plugins\ZipExtractTo;


class ExtendedS3ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('s3', function($app, $config) {
            return Storage::createS3Driver($config)->addPlugin(new ZipExtractTo());
        });
    }
}
