<?php

use App\Http\Controllers\EletrodomesticoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::post('login', [UserController::class, 'login'])->name('user.login');

Route::group(['middleware' => ['cors']], function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});

Route::group(['middleware' => ['cors', 'jwt.verify']], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    //Users
    Route::apiResource('users', UserController::class, ['except' => ['store','index']]);

    //Brands
    Route::apiResource('brands', MarcaController::class);

    //appliances
    Route::apiResource('appliances', EletrodomesticoController::class);
});
