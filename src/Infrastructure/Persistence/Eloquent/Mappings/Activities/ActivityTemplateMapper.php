<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Activities;

use Dpb\Package\Activities\Entities\ActivityTemplate;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities\EloquentActivityTemplate;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ActivityTemplateMapper
{
    public function __construct(
        private EloquentActivityTemplate $eloquentModel,
        // private ActivityTe $mgMapper,
    ) {}

    public function toDomain(EloquentActivityTemplate $model): ActivityTemplate
    {
        return new ActivityTemplate(
            id: $model->id,
            code: $model->code,
            title: $model->title,
            // description: $model->description,
            templateGroupId: $model->templateGroup?->id,
            duration: $model->duration
        );
    }

    public function toEloquent(ActivityTemplate $template): EloquentActivityTemplate
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $template->id()]);
        $model->code = $template->code();
        $model->title = $template->title();
        // $model->description = $template->description();
        $model->template_group_id = $template->templateGroupId();
        $model->duration = $template->duration();
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
