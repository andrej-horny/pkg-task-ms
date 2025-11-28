<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Dpb\Package\Tasks\Entities\TaskItemGroup;
use Dpb\Package\Tasks\Services\CreateTaskItemGroupService;

class CreateTaskItemGroupUseCase
{
    public function __construct(
        private CreateTaskItemGroupService $createSvc,
        private IdGeneratorInterface $idGenerator
    ) {}

    public function execute(array $data): ?TaskItemGroup
    {
        $taskItemGroup = new TaskItemGroup(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'] ?? null,
        );
        
        return $this->createSvc->handle($taskItemGroup);
    }
}
