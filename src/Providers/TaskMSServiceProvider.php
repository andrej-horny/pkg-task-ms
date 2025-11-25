<?php

namespace Dpb\Package\TaskMS\Providers;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models;
use Illuminate\Database\Eloquent\Relations\Relation;
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


    /**
     * Bootstrap any application services.
     */
    public function packageBooted(): void
    {
        // All future morphs *must* be mapped!
        // Relation::enforceMorphMap([
        //     'ticket' => \App\Models\TS\Ticket::class,
        //     'user' => \App\Models\User::class,
        //     'vehicle' => \App\Models\Fleet\Vehicle::class,
        // ]);
        Relation::morphMap([
            // fleet
            'eloquent-maintenance-group' => Models\Fleet\EloquentMaintenanceGroup::class,
            'eloquent-vehicle' => Models\Fleet\EloquentVehicle::class,
            'eloquent-vehicle-brand' => Models\Fleet\EloquentVehicleBrand::class,
            'eloquent-vehicle-model' => Models\Fleet\EloquentVehicleModel::class,
            'eloquent-vehicle-type' => Models\Fleet\EloquentVehicleType::class,

        ]);
    }
}
