<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\Tasks\Entities\TaskGroup;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Dpb\Package\Tasks\Services\UpdateTaskGroupService;

class UpdateTaskGroupUesCase
{
    public function __construct(
        private UpdateTaskGroupService $updateSvc,
        private TaskGroupRepositoryInterface $repository,
    ) {}

    public function execute(string $id, array $data): ?TaskGroup
    {
        $taskGroup = $this->repository->findById($id);

        if (!$taskGroup) {
            throw new \Exception("TaskGroup not found");
        }

        if (isset($data['title'])) {
            $taskGroup->rename($data['title']); // domain behavior
        }

        if (array_key_exists('code', $data)) {
            $taskGroup->updateCode($data['code']);
        }

        if (array_key_exists('description', $data)) {
            $taskGroup->updateDescription($data['description']);
        }
        
        return $this->updateSvc->handle($taskGroup);
    }
}
