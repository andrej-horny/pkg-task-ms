<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\MaintenanceGroup;
use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;
use Dpb\Package\Fleet\Repositories\VehicleTypeRepositoryInterface;
use Dpb\Package\Fleet\Services\UpdateMaintenanceGroupService;
use Dpb\Package\TaskMS\Application\Services\Fleet\AssignVehiclesToGroupService;
use Dpb\Package\TaskMS\Application\Services\Fleet\AssignVehiclesToMaintenanceGroupService;

class UpdateMaintenanceGroupUseCase
{
    public function __construct(
        private UpdateMaintenanceGroupService $updateSvc,
        private MaintenanceGroupRepositoryInterface $mgRepo,
        private VehicleTypeRepositoryInterface $vtRepo,
        private AssignVehiclesToMaintenanceGroupService $assignVehiclesSvc
    ) {}

    public function execute(string $id, array $data): ?MaintenanceGroup
    {
        $maintenanceGroup = $this->mgRepo->findById($id);

        if (isset($data['code'])) {
            $maintenanceGroup->updateCode($data['code']);
        }

        if (isset($data['title'])) {
            $maintenanceGroup->rename($data['title']);
        }

        if (isset($data['description'])) {
            $maintenanceGroup->updateDescription($data['description']);
        }

        if (isset($data['vehicle_type_id'])) {
            $type = $this->vtRepo->findById($data['vehicle_type_id']);
            $maintenanceGroup->assignVehicleType($type);
        }

        // assign vehicles
        if (isset($data['vehicles'])) {
            $this->assignVehiclesSvc->assignVehiclesToGroup($data['vehicles'], $maintenanceGroup);
        }

        return $this->updateSvc->handle($maintenanceGroup);
    }
}
