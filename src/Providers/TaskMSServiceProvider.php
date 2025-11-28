<?php

namespace Dpb\Package\TaskMS\Providers;

use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
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
            // ->discoversMigrations(true, config('pkg-task-ms.migrations_path'))
            ->discoversMigrations(true, 'src/Infrastructure/Persistence/Migrations')
            ->runsMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                ->publishConfigFile()
                // ->publishMigrations()
                ->askToRunMigrations();
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
            'eloquent-vehicle-group' => Models\Fleet\EloquentVehicleGroup::class,
            'eloquent-vehicle-model' => Models\Fleet\EloquentVehicleModel::class,
            'eloquent-vehicle-type' => Models\Fleet\EloquentVehicleType::class,

        ]);
    }

    public function packageRegistered()
    {
        // Bind interface to implementation
        $this->app->bind(IdGeneratorInterface::class, LaravelIdGenerator::class);
    }
}
