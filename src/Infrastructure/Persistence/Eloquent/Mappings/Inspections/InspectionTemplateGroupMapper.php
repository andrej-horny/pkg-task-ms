<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplateGroup;
use Dpb\Package\Inspections\Entities\InspectionTemplateGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class InspectionTemplateGroupMapper
{
    public function __construct(
        private EloquentInspectionTemplateGroup $eloquentModel,
    ) {}

    public function toDomain(EloquentInspectionTemplateGroup $model): InspectionTemplateGroup
    {
        return new InspectionTemplateGroup(
            id: $model->id,
            code: $model->code,
            title: $model->title,
            descritpion: $model->description,
        );
    }

    public function toEloquent(InspectionTemplateGroup $templateGroup): EloquentInspectionTemplateGroup
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $templateGroup->id()]);
        $model->code = $templateGroup->code();
        $model->title = $templateGroup->title();
        $model->description = $templateGroup->description();
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
