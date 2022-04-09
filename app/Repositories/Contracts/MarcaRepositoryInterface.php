<?php

namespace App\Repositories\Contracts;

interface MarcaRepositoryInterface
{
    public function getAllBrands();
    public function getBrandById(int $id);
    public function createBrand(array $brand);
    public function updateBrand(object $brand, array $brandData);
    public function destroyBrand(object $brand);

}
