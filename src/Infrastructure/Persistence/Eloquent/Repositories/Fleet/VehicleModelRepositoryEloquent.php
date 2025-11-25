<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Fleet;

use Dpb\Package\Fleet\Entities\VehicleModel;
use Dpb\Package\Fleet\Repositories\VehicleModelRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\VehicleModelMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleModel;
use Illuminate\Support\Arr;

class VehicleModelRepositoryEloquent implements VehicleModelRepositoryInterface
{
    public function __construct(
        private VehicleModelMapper $mapper,
        private EloquentVehicleModel $eloquentModel
    ) {}

    public function save(VehicleModel $vehicleModel): VehicleModel
    {
        $model = $this->mapper->toEloquent($vehicleModel);
        $model->save();
        $model->load(['type', 'brand']);
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?VehicleModel
    {
        $model = $this->eloquentModel
            ->with(['brand', 'type'])
            ->findOrFail($id);

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function all(): ?array
    {
        return $this->eloquentModel->all()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }

}
