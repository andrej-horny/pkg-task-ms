<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplateConditionType;
use Dpb\Package\Inspections\Entities\InspectionTemplateConditionType;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class InspectionTemplateConditionTypeMapper
{
    public function __construct(
        private EloquentInspectionTemplateConditionType $eloquentModel,
        private MeasurementUnitMapper $muMapper,
    ) {}

    public function toDomain(EloquentInspectionTemplateConditionType $model): InspectionTemplateConditionType
    {
        return new InspectionTemplateConditionType(
            id: $model->id,
            code: $model->code,
            title: $model->title,
            descritpion: $model->description,
            measurementUnit: $model->unit ? $this->muMapper->toDomain($model->unit): null,
        );
    }

    public function toEloquent(InspectionTemplateConditionType $conditionType): EloquentInspectionTemplateConditionType
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $conditionType->id()]);
        $model->code = $conditionType->code();
        $model->title = $conditionType->title();
        $model->description = $conditionType->description();
        $model->measurement_unit_id = $conditionType->measurementUnit()->id();
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
