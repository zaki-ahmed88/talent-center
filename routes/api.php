<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeachersController;
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


//Route::group(['prefix' => 'admin'], function(){
//
//});

//Route::group(['prefix' => 'admin'], function(){
//
//});
//
//
//
//Route::group(['prefix' => 'admin'], function(){
//
//});




Route::group(['prefix' => 'admin', 'middleware' => 'roles:Admin'], function() {

    /** Start Staff Routes */
    Route::post('staff/add', [StaffController::class, 'addStaff']);
    Route::get('staff/all', [StaffController::class, 'allStaff']);
    Route::post('staff/delete', [StaffController::class, 'deleteStaff']);
    Route::get('staff/specific', [StaffController::class, 'specificStaff']);
    Route::post('staff/update', [StaffController::class, 'updateStaff']);

});



Route::group(['prefix' => 'dashboard', 'middleware' => 'roles:Admin.Support.Secretary'], function(){


    /** Start student Routes */
    Route::post('student/add', [StudentController::class, 'addStudent']);
    Route::get('student/all', [StudentController::class, 'allStudents']);
    Route::post('student/delete', [StudentController::class, 'deleteStudent']);
    Route::get('student/specific', [StudentController::class, 'specificStudent']);
    Route::post('student/update', [StudentController::class, 'updateStudent']);





    /** Start group Routes */
    Route::post('group/add', [GroupController::class, 'addGroup']);
    Route::get('group/all', [GroupController::class, 'allGroups']);
    Route::post('group/delete', [GroupController::class, 'deleteGroup']);
    Route::get('group/specific', [GroupController::class, 'specificGroup']);
    Route::post('group/update', [GroupController::class, 'updateGroup']);


    /** Start teacher Routes */
    Route::post('teacher/add', [TeachersController::class, 'addTeacher']);
    Route::get('teacher/all', [TeachersController::class, 'allTeachers']);
    Route::post('teacher/delete', [TeachersController::class, 'deleteTeacher']);
    Route::get('teacher/specific', [TeachersController::class, 'specificTeacher']);
    Route::post('teacher/update', [TeachersController::class, 'updateTeacher']);


});

