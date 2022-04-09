<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class LoginController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            $token = $this
                ->user
                ->login($credentials);

            $user = User::where('email', '=', $request->email)->first();

        } catch (Throwable | Exception $e) {
            return ResponseService::exception('login', null, $e);
        }
        return response()->json(['status' => true, 'message' => 'Logado com sucesso', 'data' => ['user' => ['id' => $user->id, 'name' => $user->name], 'token' => $token]]);
    }

    /**
     * Logout user
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        try {
            $this
                ->user
                ->logout($request->input('token'));
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('logout', null, $e);
        }

        return response(['status' => true, 'message' => 'Deslogado com sucesso'], 200);
    }
}
