<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::post('/scan', [UserController::class, 'scan'])->name('scan');
Route::get('/invoice/{id}', [UserController::class, 'invoice'])->name('invoice');
