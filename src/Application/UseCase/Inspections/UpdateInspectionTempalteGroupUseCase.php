<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplateGroup;
use Dpb\Package\Inspections\Repositories\InspectionTemplateGroupRepositoryInterface;
use Dpb\Package\Inspections\Services\UpdateInspectionTemplateGroupService;

class UpdateInspectionTempalteGroupUseCase
{
    public function __construct(
        private UpdateInspectionTemplateGroupService $updateSvc,
        private InspectionTemplateGroupRepositoryInterface $repository,
    ) {}

    public function execute(string $id, array $data): ?InspectionTemplateGroup
    {
        $templateGroup = $this->repository->findById($id);

        if (!$templateGroup) {
            throw new \Exception("InspectionTemplateGroup not found");
        }

        if (isset($data['title'])) {
            $templateGroup->rename($data['title']); 
        }

        if (array_key_exists('code', $data)) {
            $templateGroup->updateCode($data['code']);
        }

        if (array_key_exists('description', $data)) {
            $templateGroup->updateDescription($data['description']);
        }

        return $this->updateSvc->handle($templateGroup);
    }
}
