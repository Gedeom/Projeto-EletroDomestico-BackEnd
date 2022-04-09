<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Http\Resources\MarcaResource;
use App\Services\MarcaService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class MarcaController extends Controller
{
    protected $marcaService;

    public function __construct(MarcaService $marcaService)
    {
        $this->marcaService = $marcaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $marcas = $this->marcaService->getAllBrands();
        return MarcaResource::collection($marcas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResource|JsonResponse
     */
    public function store(MarcaRequest $request)
    {
        try {
            DB::beginTransaction();
            $marca = $this->marcaService->makeBrand($request->all());
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('brands.store', null, $e);
        }
        return new MarcaResource($marca, array('type' => 'store', 'route' => 'brands.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $marca = $this->marcaService->getBrandById($id);
        } catch (Exception $e) {
            return ResponseService::exception('brands.show', $id, $e);
        }
        return new MarcaResource($marca, array('type' => 'show', 'route' => 'brands.show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResource|JsonResponse
     */
    public function update(MarcaRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $marca = $this->marcaService->updateBrand($id, $request->all());
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('brands.update', $id, $e);
        }

        return new MarcaResource($marca, array('type' => 'update', 'route' => 'brands.update'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $brand = $this->marcaService->destroyBrand($id);
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('brands.destroy', $id, $e);
        }
        return new MarcaResource($brand, array('type' => 'destroy', 'route' => 'brands.destroy'));
    }

}
