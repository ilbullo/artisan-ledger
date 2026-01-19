<?php

namespace Ilbullo\ArtisanLedger\Tests;

use Ilbullo\ArtisanLedger\ArtisanLedgerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ArtisanLedgerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Configura il database in memoria per i test
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        // Questo caricherà automaticamente tutte le migrazioni del tuo package
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->createUsersTable();
    }

    protected function createUsersTable()
    {
        \Illuminate\Support\Facades\Schema::create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
}
