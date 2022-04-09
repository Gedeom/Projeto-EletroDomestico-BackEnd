<?php

namespace App\Repositories;

use App\Models\Eletrodomestico;
use App\Repositories\Contracts\EletrodomesticoRepositoryInterface;


class EletrodomesticoRepository implements EletrodomesticoRepositoryInterface
{

    protected $entity;

    public function __construct(Eletrodomestico $appliance)
    {
        $this->entity = $appliance;
    }

    /**
     * Pegar todas eletrodomesticos
     * @return array
     */
    public function getAllAppliances()
    {
        return $this->entity->paginate();
    }

    /**
     * Seleciona a eletrodomestico por ID
     * @param int $id
     * @return object
     */
    public function getApplianceById(int $id)
    {
        return $this->entity->where('id', $id)->first();
    }

    /**
     * Cria uma nova eletrodomestico
     * @param array $appliance
     * @return object
     */
    public function createAppliance(array $appliance)
    {
        $appliance = $this->entity->create($appliance);
        return $appliance;
    }

    /**
     * Atualiza os dados da eletrodomestico
     * @param object $appliance
     * @param array $applianceData
     * @return object
     */
    public function updateAppliance(object $appliance, array $applianceData)
    {
        $appliance->update($applianceData);
        return $appliance;
    }

    /**
     * Deleta uma eletrodomestico
     * @param object $appliance
     */
    public function destroyAppliance(object $appliance)
    {
        $appliance->delete();
        return $appliance;
    }
}
