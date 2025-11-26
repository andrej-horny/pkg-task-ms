<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Fleet;

use Dpb\Package\Fleet\Entities\VehicleGroup;
use Dpb\Package\Fleet\Repositories\VehicleGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\VehicleGroupMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleGroup;
use Illuminate\Support\Arr;

class VehicleGroupRepositoryEloquent implements VehicleGroupRepositoryInterface
{
    public function __construct(
        private VehicleGroupMapper $mapper,
        private EloquentVehicleGroup $eloquentModel
    ) {}

    public function save(VehicleGroup $vehicleGroup): VehicleGroup
    {
        $model = $this->mapper->toEloquent($vehicleGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?VehicleGroup
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

    public function findByCode(string $code): ?VehicleGroup
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
