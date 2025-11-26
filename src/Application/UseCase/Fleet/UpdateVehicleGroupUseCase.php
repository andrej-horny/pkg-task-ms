<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleGroup;
use Dpb\Package\Fleet\Repositories\VehicleGroupRepositoryInterface;
use Dpb\Package\Fleet\Services\UpdateVehicleGroupService;

class UpdateVehicleGroupUseCase
{
    public function __construct(
        private UpdateVehicleGroupService $updateSvc,
        private VehicleGroupRepositoryInterface $vbRepo,
    ) {}

    public function execute(string $id, array $data): ?VehicleGroup
    {
        $vehicleGroup = $this->vbRepo->findById($id);

        if (!$vehicleGroup) {
            throw new \Exception("VehicleGroup not found");
        }

        if (array_key_exists('code', $data)) {
            $vehicleGroup->updateCode($data['code']);
        }

        if (array_key_exists('title', $data)) {
            $vehicleGroup->rename($data['title']);
        }

        if (array_key_exists('description', $data)) {
            $vehicleGroup->updateDescription($data['description']);
        }

        return $this->updateSvc->handle($vehicleGroup);
    }
}
