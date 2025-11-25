<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Fleet;

use Dpb\Package\Fleet\Entities\VehicleBrand;
use Dpb\Package\Fleet\Repositories\VehicleBrandRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\VehicleBrandMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleBrand;

class VehicleBrandRepositoryEloquent implements VehicleBrandRepositoryInterface
{
    public function __construct(
        private VehicleBrandMapper $mapper,
        private EloquentVehicleBrand $eloquentModel
    ) {}

    public function save(VehicleBrand $vehicleBrand): VehicleBrand
    {
        $model = $this->mapper->toEloquent($vehicleBrand);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?VehicleBrand
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

}
