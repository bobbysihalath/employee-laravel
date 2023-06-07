<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Exceptions\ApiException;
use App\Http\Controllers\EmployeeController;
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
Route::fallback(function(){
    throw new ApiException('Endpoint not found', 404);
});

Route::get('employees', 'EmployeeController@index');
Route::post('employees', [EmployeeController::class, 'store']);
Route::get('employees/{id}', 'EmployeeController@show');
Route::put('employees/{id}', 'EmployeeController@update');
Route::delete('employees/{id}', 'EmployeeController@destroy');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
