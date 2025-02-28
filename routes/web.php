<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\View;


Route::get('/', function () {
    return view('index');
});

Route::get('/colombia', [ApiController::class, 'index'])->name('main');
Route::get('/colombia/departamentos/{id}', [ApiController::class, 'departments'])->name('colombia.departments');