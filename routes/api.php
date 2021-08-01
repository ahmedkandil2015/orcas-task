<?php

use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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


Route::group(['prefix' => 'v1', 'namespace' => 'API/V1'], function (Router $route) {

    // $route->group(["middleware" => "auth:api"], function (Router $route) {
    $route->group([], function (Router $route) {

            $route->group(['prefix' => 'users'], function (Router $route) {
                    $route->get('list', [UserController::class, 'list']);
                    $route->get('search', [UserController::class, 'search']);
            });
    });
});
