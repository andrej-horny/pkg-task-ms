<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplateConditionType;
use Dpb\Package\Inspections\Repositories\InspectionTemplateConditionTypeRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections\InspectionTemplateConditionTypeMapper;
use Illuminate\Support\Arr;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspectionTemplateConditionType;

class InspectionTemplateConditionTypeRepositoryEloquent implements InspectionTemplateConditionTypeRepositoryInterface
{
    public function __construct(
        private InspectionTemplateConditionTypeMapper $mapper,
        private EloquentInspectionTemplateConditionType $eloquentModel
        ) {}

    public function save(InspectionTemplateConditionType $templateConditionType): InspectionTemplateConditionType
    {
        $model = $this->mapper->toEloquent($templateConditionType);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?InspectionTemplateConditionType
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

    public function findByCode(string $code): ?InspectionTemplateConditionType
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
