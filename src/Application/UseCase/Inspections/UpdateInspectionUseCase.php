<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Inspections;

use DateTimeImmutable;
use Dpb\Package\Inspections\Entities\Inspection;
use Dpb\Package\Inspections\Repositories\InspectionRepositoryInterface;
use Dpb\Package\Inspections\Repositories\InspectionTemplateRepositoryInterface;
use Dpb\Package\Inspections\Services\UpdateInspectionService;
use Dpb\Package\TaskMS\Application\Factories\Inspections\InspectionSubjectFactory;

class UpdateInspectionUseCase
{
    public function __construct(
        private UpdateInspectionService $updateSvc,
        private InspectionRepositoryInterface $repository,
        private InspectionTemplateRepositoryInterface $itRepo,
        private InspectionSubjectFactory $subjectFactory,
    ) {}
    public function execute(string $id, array $data): ?Inspection
    {
        $inspection = $this->repository->findById($id);

        if (!$inspection) {
            throw new \Exception("InspectionTemplate not found");
        }

        if (isset($data['date'])) {
            $inspection->updateDate(new DateTimeImmutable($data['date']));
        }

        $template = $this->itRepo->findById($data['template_id']);
        $inspection->assignTemplate($template);
        
        $subject = $this->subjectFactory->make('vehicle', $data['subject_id']);
        $inspection->assignSubject($subject);

        return $this->updateSvc->handle($inspection);
    }
}
