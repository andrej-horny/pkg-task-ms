<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Inspections;

use Dpb\Package\Inspections\Entities\MeasurementUnit;
use Dpb\Package\Inspections\Repositories\MeasurementUnitRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections\MeasurementUnitMapper;
use Illuminate\Support\Arr;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentMeasurementUnit;

class MeasurementUnitRepositoryEloquent implements MeasurementUnitRepositoryInterface
{
    public function __construct(
        private MeasurementUnitMapper $mapper,
        private EloquentMeasurementUnit $eloquentModel
    ) {}

    public function save(MeasurementUnit $measurementUnit): MeasurementUnit
    {
        $model = $this->mapper->toEloquent($measurementUnit);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?MeasurementUnit
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

    public function findByCode(string $code): ?MeasurementUnit
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
