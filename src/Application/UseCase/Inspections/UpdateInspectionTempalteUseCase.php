<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplate;
use Dpb\Package\Inspections\Repositories\InspectionTemplateRepositoryInterface;
use Dpb\Package\Inspections\Services\UpdateInspectionTemplateService;

class UpdateInspectionTempalteUseCase
{
    public function __construct(
        private UpdateInspectionTemplateService $updateSvc,
        private InspectionTemplateRepositoryInterface $repository,
    ) {}

    public function execute(string $id, array $data): ?InspectionTemplate
    {
        $template = $this->repository->findById($id);

        if (!$template) {
            throw new \Exception("InspectionTemplate not found");
        }

        if (isset($data['title'])) {
            $template->rename($data['title']);
        }

        if (array_key_exists('code', $data)) {
            $template->updateCode($data['code']);
        }

        $template->updateIsPeriodic(isset($data['is_periodic']));

        if (array_key_exists('description', $data)) {
            $template->updateDescription($data['description']);
        }

        return $this->updateSvc->handle($template);
    }
}
