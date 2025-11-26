<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Inspections;

use DateTimeImmutable;
use Dpb\Package\Inspections\Entities\Inspection;
use Dpb\Package\TaskMS\Application\Factories\Inspections\EloquentInspectionSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections\EloquentInspection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class InspectionMapper
{
    public function __construct(
        private EloquentInspection $eloquentModel,
        private InspectionTemplateMapper $itMapper,
        private EloquentInspectionSubjectFactory $subjectFactory,
    ) {}

    public function toDomain(EloquentInspection $model): Inspection
    {
        return new Inspection(
            id: $model->id,
            date: new \DateTimeImmutable($model->date),
            template: $model->template ? $this->itMapper->toDomain($model->template) : null,
            subject: $this->subjectFactory->make($model->subject)
        );
    }

    public function toEloquent(Inspection $inspection): EloquentInspection
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $inspection->id()]);
        $model->date = $inspection->date();
        $model->template_id = $inspection->template()->id();
        $model->subject_id = $inspection->subject()->subjectId();
        $model->subject_type = $inspection->subject()->subjectType();
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
