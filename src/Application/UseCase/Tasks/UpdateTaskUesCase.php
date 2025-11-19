<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\MaintenanceGroupAssigneeAdapter;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Repositories\TaskRepositoryInterface;
use Dpb\Package\Tasks\Services\UpdateTaskService;

class UpdateTaskUesCase
{
    public function __construct(
        private UpdateTaskService $updateSvc,
        private TaskRepositoryInterface $repository,
        private MaintenanceGroupRepositoryInterface $mgRepository,
    ) {}

    public function execute(string $id, array $data): ?Task
    {
        $task = $this->repository->findById($id);

        if (!$task) {
            throw new \Exception("Task not found");
        }

        if (isset($data['title'])) {
            $task->rename($data['title']); // domain behavior
        }

        if (array_key_exists('date', $data)) {
            $task->updateDate($data['date']);
        }

        if (array_key_exists('description', $data)) {
            $task->updateDescription($data['description']);
        }

        if (array_key_exists('group', $data)) {
            $task->assignGroupId($data['group']);
        }        

        if (array_key_exists('maintenanceGroup', $data)) {
            $maintenanceGroup = $this->mgRepository->findById($data['maintenanceGroup']);
            $assignee = new MaintenanceGroupAssigneeAdapter($maintenanceGroup);
            $task->assignTo($assignee);
        }           
        
        return $this->updateSvc->handle($task);
    }
}
