<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\EloquentTaskGroup;
use Dpb\Package\Tasks\Entities\TaskGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskGroupMapper
{
    public function toDomain(EloquentTaskGroup $model): TaskGroup
    {
        return new TaskGroup(
            $model->id,
            $model->code,
            $model->title,
            $model->description,
        );
    }

    public function toEloquent(TaskGroup $taskGroup): EloquentTaskGroup
    {
        $model = EloquentTaskGroup::firstOrNew(['id' => $taskGroup->id()]);
        $model->code = $taskGroup->code();
        $model->title = $taskGroup->title();
        $model->description = $taskGroup->description();
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
