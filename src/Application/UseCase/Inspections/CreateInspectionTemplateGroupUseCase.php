<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplateGroup;
use Dpb\Package\Inspections\Services\CreateInspectionTemplateGroupService;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;

class CreateInspectionTemplateGroupUseCase
{
    public function __construct(
        private CreateInspectionTemplateGroupService $createSvc,
        private IdGeneratorInterface $idGenerator,
    ) {}

    public function execute(array $data): ?InspectionTemplateGroup
    {
        $templateGroup = new InspectionTemplateGroup(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'],
            $data['description'] ?? null,
        );

        return $this->createSvc->handle($templateGroup);
    }
}
