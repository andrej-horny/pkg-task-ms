<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories;

use Dpb\Package\Activities\Entities\Activity;
use Dpb\Package\Activities\Repositories\ActivityRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Activities\ActivityMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities\EloquentActivity;


class ActivityRepositoryEloquent implements ActivityRepositoryInterface
{
    public function __construct(
        private ActivityMapper $mapper,
        private EloquentActivity $eloquentModel
        ) {}

    public function save(Activity $activity): Activity
    {
        $model = $this->mapper->toEloquent($activity);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?Activity
    {
        $model = $this->eloquentModel->findOrFail($id);

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function all(): ?array
    {
        return $this->eloquentModel->all()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }
}
