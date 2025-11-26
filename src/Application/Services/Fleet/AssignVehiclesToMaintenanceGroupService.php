<?php

namespace Dpb\Package\TaskMS\Application\Services\Fleet;

use Dpb\Package\Fleet\Entities\MaintenanceGroup;
use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;

class AssignVehiclesToMaintenanceGroupService
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepo
    ) {}

    public function assignVehiclesToGroup(array $vehicleIds, MaintenanceGroup $maintenanceGoup): void
    {
        // dd($vehicleIds);
        foreach ($vehicleIds as $id) {
            $vehicle = $this->vehicleRepo->findById($id);

            if ($vehicle) {
                $vehicle->assignMaintenanceGroup($maintenanceGoup);
                $this->vehicleRepo->save($vehicle);
                // dd($vehicle);
            }
        }
    }
}