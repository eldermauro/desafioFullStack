<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EmployeeController::class, 'index']);
// web.php
Route::post('/store-product', [EmployeeController::class, 'store'])->name('store');
Route::get('/edit-product', [EmployeeController::class, 'edit'])->name('edit');
Route::post('/update-product', [EmployeeController::class, 'update'])->name('update');
Route::delete('/delete-product', [EmployeeController::class, 'delete'])->name('delete');
Route::get('/fetch-all-products', [EmployeeController::class, 'fetchAll'])->name('fetchAll');
