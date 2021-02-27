<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\StaffController;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

/* Route::get('test/{name}', [ApiController::class, 'testApi']); */

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);


    Route::post('add/user/test', [AuthController::class, 'addTestUser']);

});


Route::get('test',[AuthController::class, 'test']);


Route::group(['prefix' => 'admin'], function(){

    /** Start Staff Routes */
    Route::post('staff/add', [StaffController::class, 'addStaff']);
    Route::get('staff/all', [StaffController::class, 'allStaff']);


});

