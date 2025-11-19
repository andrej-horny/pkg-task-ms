<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Activities;

use Dpb\Package\Activities\Entities\ActivityTemplateGroup;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities\EloquentActivityTemplateGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ActivityTemplateGroupMapper
{
    public function __construct(
        private EloquentActivityTemplateGroup $eloquentModel,
    ) {}

    public function toDomain(EloquentActivityTemplateGroup $model): ActivityTemplateGroup
    {
        return new ActivityTemplateGroup(
            id: $model->id,
            code: $model->code,
            title: $model->title,
            description: $model->description,
        );
    }

    public function toEloquent(ActivityTemplateGroup $group): EloquentActivityTemplateGroup
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $group->id()]);
        $model->code = $group->code();
        $model->title = $group->title();
        $model->description = $group->description();
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
