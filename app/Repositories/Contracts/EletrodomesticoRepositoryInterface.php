<?php

namespace App\Repositories\Contracts;

interface EletrodomesticoRepositoryInterface
{
    public function getAllAppliances();
    public function getApplianceById(int $id);
    public function createAppliance(array $appliance);
    public function updateAppliance(object $appliance, array $applianceData);
    public function destroyAppliance(object $appliance);

}
