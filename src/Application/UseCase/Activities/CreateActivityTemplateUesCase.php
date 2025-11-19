<?php

namespace Dpb\Package\TaskMS\Application\Activities;

use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Activities\Entities\ActivityTemplate;
use Dpb\Package\Activities\Services\CreateActivityTemplateService;

class CreateActivityTemplateUesCase
{
    public function __construct(
        private CreateActivityTemplateService $createSvc,
        private LaravelIdGenerator $idGenerator
    ) {}

    public function execute(array $data): ?ActivityTemplate
    {
        $taskGroup = new ActivityTemplate(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'] ?? null,
            // $data['description'] ?? null,
            $data['templateGroup'] ?? null,
            $data['duration'] ?? null,
        );
        
        return $this->createSvc->handle($taskGroup);
    }
}
