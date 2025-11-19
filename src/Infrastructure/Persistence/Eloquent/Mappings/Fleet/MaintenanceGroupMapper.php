<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\EloquentTaskGroup;
use Dpb\Package\Fleet\Entities\MaintenanceGroup;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentMaintenanceGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MaintenanceGroupMapper
{
    public function __construct(
        private EloquentMaintenanceGroup $eloquentModel,
    ) {}

    public function toDomain(EloquentMaintenanceGroup $model): MaintenanceGroup
    {
        return new MaintenanceGroup(
            $model->id,
            $model->code,
            $model->title,
            $model->description,
        );
    }

    public function toEloquent(MaintenanceGroup $maintenanceGroup): EloquentMaintenanceGroup
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $maintenanceGroup->id()]);
        $model->code = $maintenanceGroup->code();
        $model->title = $maintenanceGroup->title();
        $model->description = $maintenanceGroup->description();
        return $model;
    }

    public function toDomainCollection(EloquentCollection $models): array
    {
        return $models
            ->map(
                fn($model) =>
                $this->toDomain($model)
            )
            ->all();
    }
}
