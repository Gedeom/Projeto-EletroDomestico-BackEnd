<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\ResponseService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResource|JsonResponse
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->makeUser($request->all());
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('users.store', null, $e);
        }
        return new UserResource($user, array('type' => 'store', 'route' => 'users.store'));
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
            $user = $this->userService->getUserById($id);
        } catch (Exception $e) {
            return ResponseService::exception('users.show', $id, $e);
        }
        return new UserResource($user, array('type' => 'show', 'route' => 'users.show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResource|JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->updateUser($id, $request->all());
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return ResponseService::exception('users.update', $id, $e);
        }

        return new UserResource($user, array('type' => 'update', 'route' => 'users.update'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->destroyUser($id);
            DB::commit();
        } catch (Exception | Throwable $e) {
            DB::commit();
            return ResponseService::exception('users.destroy', $id, $e);
        }
        return new UserResource($user, array('type' => 'destroy', 'route' => 'users.destroy'));
    }

}
