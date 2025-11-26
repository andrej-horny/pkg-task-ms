<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\TaskMS\Application\Factories\Tasks\TaskAssigneeFactory;
use Dpb\Package\TaskMS\Application\Factories\Tasks\TaskSubjectFactory;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Repositories\TaskRepositoryInterface;
use Dpb\Package\Tasks\Services\UpdateTaskService;

class UpdateTaskUseCase
{
    public function __construct(
        private UpdateTaskService $updateSvc,
        private TaskRepositoryInterface $repository,
        private TaskSubjectFactory $subjectFactory,
        private TaskAssigneeFactory $assigneeFactory,
    ) {}

    public function execute(string $id, array $data): ?Task
    {
        // dd($data);
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

        if (array_key_exists('group_id', $data)) {
            $task->assignGroupId($data['group_id']);
        }        

        if (array_key_exists('subject_id', $data)) {
            $subject = $this->subjectFactory->make('vehicle', $data['subject_id']);
            $task->assignSubject($subject);
        }  

        if (array_key_exists('assigned_to_id', $data)) {
            $assignee = $this->assigneeFactory->make('maintenance-group', $data['assigned_to_id']);
            $task->assignTo($assignee);
        }         
        
        return $this->updateSvc->handle($task);
    }
}
