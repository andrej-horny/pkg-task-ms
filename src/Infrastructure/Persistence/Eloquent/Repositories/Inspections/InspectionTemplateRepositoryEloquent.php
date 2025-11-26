<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplate;
use Dpb\Package\Inspections\Repositories\InspectionTemplateRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections\InspectionTemplateMapper;
use Illuminate\Support\Arr;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplate;

class InspectionTemplateRepositoryEloquent implements InspectionTemplateRepositoryInterface
{
    public function __construct(
        private InspectionTemplateMapper $mapper,
        private EloquentInspectionTemplate $eloquentModel
        ) {}

    public function save(InspectionTemplate $template): InspectionTemplate
    {
        $model = $this->mapper->toEloquent($template);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?InspectionTemplate
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

    public function findByCode(string $code): ?InspectionTemplate
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
