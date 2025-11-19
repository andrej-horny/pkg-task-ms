<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Activities;

use Dpb\Package\Activities\Entities\Activity;
use Dpb\Package\Activities\Entities\ActivityTemplate;
use Dpb\Package\Activities\Repositories\ActivityTemplateRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Activities\ActivityMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Activities\ActivityTemplateMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities\EloquentActivity;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities\EloquentActivityTemplate;
use Illuminate\Support\Arr;

class ActivityTemplateRepositoryEloquent implements ActivityTemplateRepositoryInterface
{
    public function __construct(
        private ActivityTemplateMapper $mapper,
        private EloquentActivityTemplate $eloquentModel
    ) {}

    public function save(ActivityTemplate $template): ActivityTemplate
    {
        $model = $this->mapper->toEloquent($template);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?ActivityTemplate
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

    public function findByCode(string $code): ?ActivityTemplate
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
