<?php

namespace App\Http\Controllers;

use App\Http\Requests\EletrodomesticoRequest;
use App\Http\Resources\EletrodomesticoResource;
use App\Services\EletrodomesticoService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class EletrodomesticoController extends Controller
{
    protected $eletrodomesticoService;

    public function __construct(EletrodomesticoService $eletrodomesticoService)
    {
        $this->eletrodomesticoService = $eletrodomesticoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $eletrodomesticos = $this->eletrodomesticoService->getAllAppliances();
        return EletrodomesticoResource::collection($eletrodomesticos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResource|JsonResponse
     */
    public function store(EletrodomesticoRequest $request)
    {
        try {
            DB::beginTransaction();
            $eletrodomestico = $this->eletrodomesticoService->makeAppliance($request->all());
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('appliances.store', null, $e);
        }
        return new EletrodomesticoResource($eletrodomestico, array('type' => 'store', 'route' => 'appliances.store'));
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
            $eletrodomestico = $this->eletrodomesticoService->getApplianceById($id);
        } catch (Exception $e) {
            return ResponseService::exception('appliances.show', $id, $e);
        }
        return new EletrodomesticoResource($eletrodomestico, array('type' => 'show', 'route' => 'appliances.show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResource|JsonResponse
     */
    public function update(EletrodomesticoRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $eletrodomestico = $this->eletrodomesticoService->updateAppliance($id, $request->all());
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('appliances.update', $id, $e);
        }

        return new EletrodomesticoResource($eletrodomestico, array('type' => 'update', 'route' => 'appliances.update'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $appliance = $this->eletrodomesticoService->destroyAppliance($id);
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('appliances.destroy', $id, $e);
        }
        return new EletrodomesticoResource($appliance, array('type' => 'destroy', 'route' => 'appliances.destroy'));
    }

}
