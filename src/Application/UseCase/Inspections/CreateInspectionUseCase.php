<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Inspections;

use DateTimeImmutable;
use Dpb\Package\Inspections\Entities\Inspection;
use Dpb\Package\Inspections\Repositories\InspectionTemplateRepositoryInterface;
use Dpb\Package\Inspections\Services\CreateInspectionService;
use Dpb\Package\TaskMS\Application\Factories\Inspections\InspectionSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;

class CreateInspectionUseCase
{
    protected const SUBJECT_TYPE = 'vehicle';

    public function __construct(
        private CreateInspectionService $createSvc,
        private IdGeneratorInterface $idGenerator,
        private InspectionTemplateRepositoryInterface $itRepo,
        private InspectionSubjectFactory $subjectFactory,
    ) {}

    public function execute(array $data): ?Inspection
    {
        // template
        $template = $this->itRepo->findById($data['template_id']);
        // subject
        $subject = null;

        // if (!empty($data['subject_type']) && !empty($data['subject_id'])) {
        if (!empty($data['subject_id'])) {
            $subject = $this->subjectFactory
                // ->make($data['subject_type'], $data['subject_id']);
                ->make(self::SUBJECT_TYPE, $data['subject_id']);
        }

        $inspection = new Inspection(
            $this->idGenerator->generate(),
            new DateTimeImmutable($data['date']),
            $template,
            $subject
        );

        return $this->createSvc->handle($inspection);
    }
}
