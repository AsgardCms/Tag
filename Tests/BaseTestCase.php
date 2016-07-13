<?php

namespace Modules\Tag\Tests;

use Illuminate\View\ViewServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\Tag\Providers\TagServiceProvider;
use Nwidart\Modules\LaravelModulesServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ViewServiceProvider::class,
            LaravelModulesServiceProvider::class,
            CoreServiceProvider::class,
            TagServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('translatable.locales', ['en', 'fr']);
    }
}
