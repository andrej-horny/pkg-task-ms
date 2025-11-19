<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Activities;

use Dpb\Package\Activities\Entities\ActivityTemplateGroup;
use Dpb\Package\Activities\Repositories\ActivityTemplateGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Activities\ActivityTemplateGroupMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities\EloquentActivityTemplateGroup;
use Illuminate\Support\Arr;

class ActivityTemplateGroupRepositoryEloquent implements ActivityTemplateGroupRepositoryInterface
{
    public function __construct(
        private ActivityTemplateGroupMapper $mapper,
        private EloquentActivityTemplateGroup $eloquentModel
    ) {}

    public function save(ActivityTemplateGroup $group): ActivityTemplateGroup
    {
        $model = $this->mapper->toEloquent($group);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?ActivityTemplateGroup
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

    public function findByCode(string $code): ?ActivityTemplateGroup
    {
        $model = $this->eloquentModel
            ->where('code', '=', $code)
            ->first();

        return $this->mapper->toDomain($model);
    }

    public function byCode(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return $this->eloquentModel->whereIn('code', $code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }
}
