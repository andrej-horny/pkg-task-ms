<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplate;
use Dpb\Package\Inspections\Entities\InspectionTemplate;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class InspectionTemplateMapper
{
    public function __construct(
        private EloquentInspectionTemplate $eloquentModel,
    ) {}

    public function toDomain(EloquentInspectionTemplate $model): InspectionTemplate
    {
        return new InspectionTemplate(
            id: $model->id,
            code: $model->code,
            title: $model->title,
            isPeriodic: $model->is_periodic,
            descritpion: $model->description,
        );
    }

    public function toEloquent(InspectionTemplate $template): EloquentInspectionTemplate
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $template->id()]);
        $model->code = $template->code();
        $model->title = $template->title();
        $model->is_periodic = $template->isPeriodic();
        $model->description = $template->description();
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
