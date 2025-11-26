<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplateCondition;
use Dpb\Package\Inspections\Entities\InspectionTemplateCondition;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class InspectionTemplateConditionMapper
{
    public function __construct(
        private EloquentInspectionTemplateCondition $eloquentModel,
        private InspectionTemplateConditionTypeMapper $itcMapper,
    ) {}

    public function toDomain(EloquentInspectionTemplateCondition $model): InspectionTemplateCondition
    {
        return new InspectionTemplateCondition(
            id: $model->id,
            code: $model->code,
            title: $model->title,
            descritpion: $model->description,
            conditionType: $model->type ? $this->itcMapper->toDomain($model->type): null,
        );
    }

    public function toEloquent(InspectionTemplateCondition $templateCondition): EloquentInspectionTemplateCondition
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $templateCondition->id()]);
        $model->code = $templateCondition->code();
        $model->title = $templateCondition->title();
        $model->description = $templateCondition->description();
        $model->type_id = $templateCondition->conditionType()->id();
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
