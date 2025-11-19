<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Activities;

use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Activities\Entities\ActivityTemplateGroup;
use Dpb\Package\Activities\Services\CreateActivityTemplateGroupService;

class CreateActivityTemplateGroupUesCase
{
    public function __construct(
        private CreateActivityTemplateGroupService $createSvc,
        private LaravelIdGenerator $idGenerator
    ) {}

    public function execute(array $data): ?ActivityTemplateGroup
    {
        $taskGroup = new ActivityTemplateGroup(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'] ?? null,
            $data['description'] ?? null,
        );
        
        return $this->createSvc->handle($taskGroup);
    }
}
