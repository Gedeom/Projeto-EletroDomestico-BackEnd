<?php

namespace App\Repositories;

use App\Models\Marca;
use App\Repositories\Contracts\MarcaRepositoryInterface;


class MarcaRepository implements MarcaRepositoryInterface
{

    protected $entity;

    public function __construct(Marca $brand)
    {
        $this->entity = $brand;
    }

    /**
     * Pegar todas marcas
     * @return array
     */
    public function getAllBrands()
    {
        return $this->entity->paginate();
    }

    /**
     * Seleciona a marca por ID
     * @param int $id
     * @return object
     */
    public function getBrandById(int $id)
    {
        return $this->entity->where('id', $id)->first();
    }

    /**
     * Cria uma nova marca
     * @param array $brand
     * @return object
     */
    public function createBrand(array $brand)
    {
        $brand = $this->entity->create($brand);
        return $brand;
    }

    /**
     * Atualiza os dados da marca
     * @param object $brand
     * @param array $brandData
     * @return object
     */
    public function updateBrand(object $brand, array $brandData)
    {
        $brand->update($brandData);
        return $brand;
    }

    /**
     * Deleta uma marca
     * @param object $brand
     */
    public function destroyBrand(object $brand)
    {
        $brand->delete();
        return $brand;
    }
}
