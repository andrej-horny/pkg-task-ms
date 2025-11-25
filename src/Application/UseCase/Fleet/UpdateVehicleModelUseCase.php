<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleModel;
use Dpb\Package\Fleet\Repositories\VehicleBrandRepositoryInterface;
use Dpb\Package\Fleet\Repositories\VehicleModelRepositoryInterface;
use Dpb\Package\Fleet\Repositories\VehicleTypeRepositoryInterface;
use Dpb\Package\Fleet\Services\UpdateVehicleModelService;

class UpdateVehicleModelUseCase
{
    public function __construct(
        private UpdateVehicleModelService $updateSvc,
        private VehicleModelRepositoryInterface $vmRepo,
        private VehicleBrandRepositoryInterface $vbRepo,
        private VehicleTypeRepositoryInterface $vtRepo,
    ) {}

    public function execute(string $id, array $data): ?VehicleModel
    {
        $vehicleModel = $this->vmRepo->findById($id);

        if (!$vehicleModel) {
            throw new \Exception("VehicleModel not found");
        }

        if (array_key_exists('title', $data)) {
            $vehicleModel->rename($data['title']);
        }

        if (array_key_exists('year', $data)) {
            $vehicleModel->updateYear($data['year']);
        }

        if (isset($data['brand_id'])) {
            $brand = $this->vbRepo->findById($data['brand_id']);
            $vehicleModel->assignBrand($brand);
        }
        else {
            $vehicleModel->assignBrand(null);
        }

        if (isset($data['type_id'])) {
            $type = $this->vtRepo->findById($data['type_id']);
            $vehicleModel->assignType($type);
        }
        else {
            $vehicleModel->assignType(null);
        }

        return $this->updateSvc->handle($vehicleModel);
    }
}
