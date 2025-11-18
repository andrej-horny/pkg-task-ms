<?php

namespace Dpb\Package\TaskMS\Providers;

use Illuminate\Support\Facades\Artisan;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TaskMSServiceProvider extends PackageServiceProvider
{
    // public function register()
    // {
    //     $this->app->bind(ContactRepositoryInterface::class, EloquentContactRepository::class);
    // }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('pkg-task-ms')
            ->hasConfigFile()
            ->hasMigrations([
                '0001_create_tasks_tables',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->publishConfigFile()
                    ->askToRunMigrations()
                    ->endWith(function () {
                        // Artisan::call('db:seed', [
                        //     '--class' => \Dpb\Packages\Tasks\Database\Seeders\DatabaseSeeder::class,
                        //     '--force' => true,
                        // ]);
                    });
            });
    }    
}
