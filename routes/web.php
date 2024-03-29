<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing.index');
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'show_register'])->name('auth.show_register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');

    Route::get('/login'); // возможно неправильно
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
});

Route::middleware('auth')->group(function () {

    Route::get('/task/add', [\App\Http\Controllers\TaskController::class, 'showStore'])->name('task.show_store');
    Route::post('/task/add', [\App\Http\Controllers\TaskController::class, 'store'])->name('task.store');

    Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.send_filter');
    Route::get('/file/{name}', [\App\Http\Controllers\TaskController::class, 'get_file'])->name('task.get_file');

    Route::post('/task/{task}', [\App\Http\Controllers\ResponseController::class, 'to_response'])->name('task.to_response');

    Route::get('/task/{task}', [\App\Http\Controllers\TaskController::class, 'show'])->name('task.show');
    Route::get('/user/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('user.show');

    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});

