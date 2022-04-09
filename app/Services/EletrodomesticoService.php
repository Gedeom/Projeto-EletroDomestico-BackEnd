<?php

namespace App\Services;

use App\Repositories\Contracts\EletrodomesticoRepositoryInterface;
use Exception;

class EletrodomesticoService
{
    protected $eletrodomesticoRepository;

    public function __construct(EletrodomesticoRepositoryInterface $eletrodomesticoRepository)
    {
        $this->eletrodomesticoRepository = $eletrodomesticoRepository;
    }

    /**
     *
     */
    public function getAllAppliances()
    {
        return $this->eletrodomesticoRepository->getAllAppliances();
    }

    /**
     *
     */
    public function getApplianceById(int $id)
    {
        $appliance = $this->eletrodomesticoRepository->getApplianceById($id);

        if (!$appliance) {
            throw new Exception('Eletrodomestico não encontrado!', -404);
        }

        return $appliance;
    }

    /**
     *
     */
    public function makeAppliance(array $appliance)
    {
        $data =  $this->eletrodomesticoRepository->createAppliance($appliance);
        return $data;
    }

    /**
     *
     */
    public function updateAppliance(int $id, array $applianceData)
    {

        $appliance = $this->eletrodomesticoRepository->getApplianceById($id);

        if (!$appliance) {
            throw new Exception('Eletrodomestico não encontrada!', -404);
        }


        $data = $this->eletrodomesticoRepository->updateAppliance($appliance, $applianceData);
        return $data;
    }

    /**
     *
     */
    public function destroyAppliance(int $id)
    {

        $eletrodomestico = $this->eletrodomesticoRepository->getApplianceById($id);

        if (!$eletrodomestico) {
            throw new Exception('Eletrodomestico não encontrado!', -404);
        }
        $this->eletrodomesticoRepository->destroyAppliance($eletrodomestico);

        return $eletrodomestico;
    }
}
