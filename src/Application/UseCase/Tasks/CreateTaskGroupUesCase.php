<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tasks\Entities\TaskGroup;
use Dpb\Package\Tasks\Services\CreateTaskGroupService;

class CreateTaskGroupUesCase
{
    public function __construct(
        private CreateTaskGroupService $createSvc,
        private LaravelIdGenerator $idGenerator
    ) {}

    public function execute(array $data): ?TaskGroup
    {
        $taskGroup = new TaskGroup(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'] ?? null,
            $data['description'] ?? null,
        );
        
        return $this->createSvc->handle($taskGroup);
    }
}
