<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Application\Factories\Tasks\TaskAssigneeFactory;
use Dpb\Package\TaskMS\Application\Factories\Tasks\TaskSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Entities\TaskItem;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Dpb\Package\Tasks\Repositories\TaskItemGroupRepositoryInterface;
use Dpb\Package\Tasks\Repositories\TaskRepositoryInterface;
use Dpb\Package\Tasks\Services\UpdateTaskService;

class AddTaskItemUseCase
{
    public function __construct(
        private UpdateTaskService $updateSvc,
        private TaskRepositoryInterface $repository,
        private IdGeneratorInterface $idGenerator,
        private TaskItemGroupRepositoryInterface $tigRepo,
    ) {}

    public function execute(string $taskId, array $taskItemData): ?Task
    {

        // dd($taskItemData);
        $task = $this->repository->findById($taskId);

        if (!$task) {
            throw new \Exception("Task not found");
        }

        // create task items
        $taskItem = new TaskItem(
            $this->idGenerator->generate(),
            // $taskItemData['code'] ?? null,
            new DateTimeImmutable($taskItemData['date']),
            $taskItemData['title'] ?? 'generic title',
            $taskItemData['description'] ?? null,
            $this->tigRepo->findById($taskItemData['group_id'])
        );

        $task->addTaskItem($taskItem);
// print_r($task);
        return $this->updateSvc->handle($task);
    }
}
