<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Inspections;

use Dpb\Package\Inspections\Entities\InspectionTemplate;
use Dpb\Package\Inspections\Services\CreateInspectionTemplateService;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;

class CreateInspectionTemplateUseCase
{
    public function __construct(
        private CreateInspectionTemplateService $createSvc,
        private IdGeneratorInterface $idGenerator,
    ) {}

    public function execute(array $data): ?InspectionTemplate
    {
        $template = new InspectionTemplate(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'],
            $data['is_periodic'] ? 1 : 0,
            $data['description'] ?? null,
        );

        return $this->createSvc->handle($template);
    }
}
