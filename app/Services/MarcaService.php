<?php

namespace App\Services;

use App\Repositories\Contracts\MarcaRepositoryInterface;
use Exception;

class MarcaService
{
    protected $marcaRepository;

    public function __construct(MarcaRepositoryInterface $marcaRepository)
    {
        $this->marcaRepository = $marcaRepository;
    }

    /**
     *
     */
    public function getAllBrands()
    {
        return $this->marcaRepository->getAllBrands();
    }

    /**
     *
     */
    public function getBrandById(int $id)
    {
        $brand = $this->marcaRepository->getBrandById($id);

        if (!$brand) {
            throw new Exception('Marca não encontrada!', -404);
        }

        return $brand;
    }

    /**
     *
     */
    public function makeBrand(array $brand)
    {
        throw new Exception('Não suportado!', -403);

        $data =  $this->marcaRepository->createBrand($brand);
        return $data;
    }

    /**
     *
     */
    public function updateBrand(int $id, array $brandData)
    {
        throw new Exception('Não suportado!', -403);

        $brand = $this->marcaRepository->getBrandById($id);


        if (!$brand) {
            throw new Exception('Marca não encontrada!', -404);
        }


        $data = $this->marcaRepository->updateBrand($brand, $brandData);
        return $data;
    }

    /**
     *
     */
    public function destroyBrand(int $id)
    {
        throw new Exception('Não suportado!', -403);

        $marca = $this->marcaRepository->getBrandById($id);

        if (!$marca) {
            throw new Exception('Marca não encontrado!', -404);
        }
        $this->marcaRepository->destroyBrand($marca);

        return $marca;
    }
}
