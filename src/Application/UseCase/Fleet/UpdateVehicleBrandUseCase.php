<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleBrand;
use Dpb\Package\Fleet\Repositories\VehicleBrandRepositoryInterface;
use Dpb\Package\Fleet\Services\UpdateVehicleBrandService;

class UpdateVehicleBrandUseCase
{
    public function __construct(
        private UpdateVehicleBrandService $updateSvc,
        private VehicleBrandRepositoryInterface $vbRepo,
    ) {}

    public function execute(string $id, array $data): ?VehicleBrand
    {
        $vehicleBrand = $this->vbRepo->findById($id);

        if (!$vehicleBrand) {
            throw new \Exception("TicketType not found");
        }

        if (array_key_exists('title', $data)) {
            $vehicleBrand->rename($data['title']);
        }

        return $this->updateSvc->handle($vehicleBrand);
    }
}
