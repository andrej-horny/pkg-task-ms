<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Activities;

use Dpb\Package\Activities\Entities\ActivityTemplate;
use Dpb\Package\Activities\Repositories\ActivityTemplateRepositoryInterface;
use Dpb\Package\Activities\Services\UpdateActivityTemplateService;

class UpdateActivityTemplateUesCase
{
    public function __construct(
        private UpdateActivityTemplateService $updateSvc,
        private ActivityTemplateRepositoryInterface $repository
    ) {}

    public function execute(string $id, array $data): ?ActivityTemplate
    {
        $template = $this->repository->findById($id);

        if (!$template) {
            throw new \Exception("ActivityTemplate not found");
        }

        if (isset($data['title'])) {
            $template->rename($data['title']); // domain behavior
        }

        if (array_key_exists('code', $data)) {
            $template->updateCode($data['code']);
        }

        if (array_key_exists('duration', $data)) {
            $template->updateDuration($data['duration']);
        }

        if (array_key_exists('group', $data)) {
            $template->assignGroupId($data['group']);
        }             
        
        return $this->updateSvc->handle($template);

    }
}
