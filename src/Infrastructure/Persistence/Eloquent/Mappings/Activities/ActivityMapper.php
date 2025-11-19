<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Activities;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities\EloquentActivity;
use Dpb\Package\Activities\Entities\Activity;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ActivityMapper
{
    public function __construct(
        private EloquentActivity $eloquentModel,
        private ActivityTemplateMapper $atMapper,
    ) {}

    public function toDomain(EloquentActivity $model): Activity
    {
        $template = $this->atMapper->toDomain($model->template);

        return new Activity(
            id: $model->id,
            date: $model->date,
            template: $template,
            note: $model->note
        );
    }

    public function toEloquent(Activity $activity): EloquentActivity
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $activity->id()]);
        $model->date = $activity->date();
        $model->note = $activity->note();
        $model->template()->associate($this->atMapper->toEloquent($activity->template()));
        // $model->sate = $task->state();
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
