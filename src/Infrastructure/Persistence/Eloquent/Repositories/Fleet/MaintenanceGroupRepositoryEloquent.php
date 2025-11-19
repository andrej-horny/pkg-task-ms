<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Fleet;

use Dpb\Package\Fleet\Entities\MaintenanceGroup;
use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\MaintenanceGroupMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentMaintenanceGroup;
use Illuminate\Support\Arr;

class MaintenanceGroupRepositoryEloquent implements MaintenanceGroupRepositoryInterface
{
    public function __construct(
        private MaintenanceGroupMapper $mapper,
        private EloquentMaintenanceGroup $eloquentModel
    ) {}

    public function save(MaintenanceGroup $maintenanceGroup): MaintenanceGroup
    {
        $model = $this->mapper->toEloquent($maintenanceGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?MaintenanceGroup
    {
        $model = $this->eloquentModel->findOrFail($id);

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function all(): ?array
    {
        return $this->eloquentModel->all()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }

    public function findByCode(string $code): ?MaintenanceGroup
    {
        $model = $this->eloquentModel
            ->where('code', '=', $code)
            ->first();
        
            return $this->mapper->toDomain($model);
    }

    public function byCode(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return $this->eloquentModel->whereIn('code', $code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }    
}
