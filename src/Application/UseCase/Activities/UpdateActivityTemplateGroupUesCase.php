<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Activities;

use Dpb\Package\Activities\Services\UpdateActivityTemplateGroupService;
use Dpb\Package\Activities\Entities\ActivityTemplateGroup;
use Dpb\Package\Activities\Repositories\ActivityTemplateGroupRepositoryInterface;

class UpdateActivityTemplateGroupUesCase
{
    public function __construct(
        private UpdateActivityTemplateGroupService $updateSvc,
        private ActivityTemplateGroupRepositoryInterface $repository,
    ) {}

    public function execute(string $id, array $data): ?ActivityTemplateGroup
    {
        $atGroup = $this->repository->findById($id);

        if (!$atGroup) {
            throw new \Exception("ActivityTemplateGroup not found");
        }

        if (isset($data['title'])) {
            $atGroup->rename($data['title']); // domain behavior
        }

        if (array_key_exists('code', $data)) {
            $atGroup->updateCode($data['code']);
        }

        if (array_key_exists('description', $data)) {
            $atGroup->updateDescription($data['description']);
        }
        
        return $this->updateSvc->handle($atGroup);
    }
}
