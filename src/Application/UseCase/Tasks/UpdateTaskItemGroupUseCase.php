<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\Tasks\Entities\TaskItemGroup;
use Dpb\Package\Tasks\Repositories\TaskItemGroupRepositoryInterface;
use Dpb\Package\Tasks\Services\UpdateTaskItemGroupService;

class UpdateTaskItemGroupUseCase
{
    public function __construct(
        private UpdateTaskItemGroupService $updateSvc,
        private TaskItemGroupRepositoryInterface $repository,
    ) {}

    public function execute(string $id, array $data): ?TaskItemGroup
    {
        $taskItemGroup = $this->repository->findById($id);

        if (!$taskItemGroup) {
            throw new \Exception("TaskItemGroup not found");
        }

        if (array_key_exists('code', $data)) {
            $taskItemGroup->updateCode($data['code']);
        }

        if (isset($data['title'])) {
            $taskItemGroup->rename($data['title']); // domain behavior
        }
        
        return $this->updateSvc->handle($taskItemGroup);
    }
}
