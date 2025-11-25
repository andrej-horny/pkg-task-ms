<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Fleet;

use Dpb\Package\Fleet\Entities\VehicleType;
use Dpb\Package\Fleet\Repositories\VehicleTypeRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\VehicleTypeMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleType;
use Illuminate\Support\Arr;

class VehicleTypeRepositoryEloquent implements VehicleTypeRepositoryInterface
{
    public function __construct(
        private VehicleTypeMapper $mapper,
        private EloquentVehicleType $eloquentModel
    ) {}

    public function save(VehicleType $vehicleType): VehicleType
    {
        $model = $this->mapper->toEloquent($vehicleType);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?VehicleType
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

    public function findByCode(string $code): ?VehicleType
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
