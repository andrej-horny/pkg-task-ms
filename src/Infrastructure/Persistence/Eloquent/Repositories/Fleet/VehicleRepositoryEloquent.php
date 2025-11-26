<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Fleet;

use Dpb\Package\Fleet\Entities\Vehicle;
use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\VehicleMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use Illuminate\Support\Arr;

class VehicleRepositoryEloquent implements VehicleRepositoryInterface
{
    public function __construct(
        private VehicleMapper $mapper,
        private EloquentVehicle $eloquentModel
    ) {}

    public function save(Vehicle $vehicle): Vehicle
    {
        $model = $this->mapper->toEloquent($vehicle);
        $model->save();
        dd($model);
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?Vehicle
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

    public function findByCode(string $code): ?Vehicle
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
    
    public function byMaintenanceGroup(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return $this->eloquentModel
            ->byMaintenanceGroup($code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }       

    public function byGroup(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return $this->eloquentModel
            ->byGroup($code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }    

    public function byType(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return $this->eloquentModel
            ->byType($code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    } 
    
    public function byBrand(string|array $title): ?array
    {
        $code = Arr::wrap($title);

        return $this->eloquentModel
            ->byBrand($title)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }     
}
