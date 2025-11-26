<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplateGroup;
use Dpb\Package\Inspections\Repositories\InspectionTemplateGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections\InspectionTemplateGroupMapper;
use Illuminate\Support\Arr;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplateGroup;

class InspectionTemplateGroupRepositoryEloquent implements InspectionTemplateGroupRepositoryInterface
{
    public function __construct(
        private InspectionTemplateGroupMapper $mapper,
        private EloquentInspectionTemplateGroup $eloquentModel
        ) {}

    public function save(InspectionTemplateGroup $templateGroup): InspectionTemplateGroup
    {
        $model = $this->mapper->toEloquent($templateGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?InspectionTemplateGroup
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

    public function findByCode(string $code): ?InspectionTemplateGroup
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
