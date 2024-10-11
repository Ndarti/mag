<?php

use App\Http\Controllers\EntranceController;
use App\Http\Controllers\PeopleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcom');
});
Route::get('/entrance', [EntranceController::class, 'entrance']);
Route::post('/entrance/check', [EntranceController::class, 'check_entrance',]);
Route::any('/entrance/check/mag', [EntranceController::class, 'mag_check_entrance']);
Route::post('/controller/action/{data1}/{data2}', [EntranceController::class, 'new_mark']);
Route::post('/controller/action/new_mark/{data1}/{data2}/{data3}/{data4}/{data5}', [EntranceController::class, 'new_m']);
Route::post('/academic_performance', [PeopleController::class, 'pass']);
Route::post('/mes_prop', [PeopleController::class, 'mes_prop']);
Route::post('/new_prop', [PeopleController::class, 'new_prop']);
Route::post('/graf', [PeopleController::class, 'graf']);
Route::post('/admin', [PeopleController::class, 'admin']);
Route::post('/user', [PeopleController::class, 'user']);
Route::post('/group', [PeopleController::class, 'group']);
Route::post('/addSubject', [PeopleController::class, 'addSubject']);
