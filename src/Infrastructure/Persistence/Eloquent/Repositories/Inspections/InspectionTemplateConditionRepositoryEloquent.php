<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplateCondition;
use Dpb\Package\Inspections\Repositories\InspectionTemplateConditionRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections\InspectionTemplateConditionMapper;
use Illuminate\Support\Arr;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplateCondition;

class InspectionTemplateConditionRepositoryEloquent implements InspectionTemplateConditionRepositoryInterface
{
    public function __construct(
        private InspectionTemplateConditionMapper $mapper,
        private EloquentInspectionTemplateCondition $eloquentModel
        ) {}

    public function save(InspectionTemplateCondition $templateCondition): InspectionTemplateCondition
    {
        $model = $this->mapper->toEloquent($templateCondition);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?InspectionTemplateCondition
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

    public function findByCode(string $code): ?InspectionTemplateCondition
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
