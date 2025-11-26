<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Inspections;

use Dpb\Package\Inspections\Entities\Inspection;
use Dpb\Package\Inspections\Repositories\InspectionRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections\InspectionMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspection;
use Illuminate\Support\Arr;

class InspectionRepositoryEloquent implements InspectionRepositoryInterface
{
    public function __construct(
        private InspectionMapper $mapper,
        private EloquentInspection $eloquentModel
        ) {}

    public function save(Inspection $templateGroup): Inspection
    {
        $model = $this->mapper->toEloquent($templateGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?Inspection
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
