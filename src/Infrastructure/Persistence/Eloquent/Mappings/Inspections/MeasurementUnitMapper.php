<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections;

use Dpb\Package\Inspections\Entities\MeasurementUnit;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentMeasurementUnit;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MeasurementUnitMapper
{
    public function __construct(
        private EloquentMeasurementUnit $eloquentModel,
    ) {}

    public function toDomain(EloquentMeasurementUnit $model): MeasurementUnit
    {
        return new MeasurementUnit(
            id: $model->id,
            code: $model->code,
            title: $model->title,
            descritpion: $model->description,
        );
    }

    public function toEloquent(MeasurementUnit $measurementUnit): EloquentMeasurementUnit
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $measurementUnit->id()]);
        $model->code = $measurementUnit->code();
        $model->title = $measurementUnit->title();
        $model->description = $measurementUnit->description();
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
