<?php

use App\Http\Controllers\TypeDocumentController;
use App\Http\Controllers\TypeUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('user-store', 'store');
        Route::get('/validate-sesion',  'validateSesion');
        Route::get('/users-list{limit?}',  'index');
        Route::get('user-logout', 'logout');
    });
});


Route::controller(UserController::class)->group(function () {
    /*  Route::post('user-store', 'store'); */
    Route::post('/user-login', 'login');
});

Route::get('/types-document', [TypeDocumentController::class, 'index']);
Route::get('/types-users', [TypeUserController::class, 'index']);