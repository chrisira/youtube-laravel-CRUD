<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('employees',[EmployeeController::class,'index']);
Route::get('fetch_employees',[EmployeeController::class,'fetch_employees']);
Route::post('employees',[EmployeeController::class,'store']);
Route::get('edit_employee/{id}',[EmployeeController::class,'edit']);
Route::put('update_employee/{id}',[EmployeeController::class,'update']);
Route::delete('delete-employee/{id}',[EmployeeController::class,'destroy']);



