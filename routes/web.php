<?php

use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
})->name('dashboard');


Route::prefix('employees')->group(function () 
{
    Route::get('/', App\Http\Livewire\Employee\EmployeesList::class )->name('employees.list');
    Route::get('add', App\Http\Livewire\Employee\AddOrEditEmployee::class )->name('employees.add');
    Route::get('edit/{id}', App\Http\Livewire\Employee\AddOrEditEmployee::class )->name('employees.edit');
    
    Route::post('load-employeeslist', [App\Http\Controllers\EmployyesController::class, 'loadEmployeeslist'] )->name('get-employees-list-for-datatable');
    
    
    
}); 



