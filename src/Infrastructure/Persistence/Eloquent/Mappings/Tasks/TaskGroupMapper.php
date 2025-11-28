<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTaskGroup;
use Dpb\Package\Tasks\Entities\TaskGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskGroupMapper
{
    public function toDomain(EloquentTaskGroup $model): TaskGroup
    {
        return new TaskGroup(
            $model->id,
            $model->uri,
            $model->title,
            $model->description,
        );
    }

    public function toEloquent(TaskGroup $taskGroup): EloquentTaskGroup
    {
        $model = EloquentTaskGroup::firstOrNew(['id' => $taskGroup->id()]);
        $model->uri = $taskGroup->uri();
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
