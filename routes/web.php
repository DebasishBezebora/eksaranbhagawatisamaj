<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerRoute;
// use App\Http\Controllers\CustomAuthController;
// use App\Http\Controllers\examMaster;

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

Route::get('/', [ControllerRoute::class, 'home']);
Route::get('/program', [ControllerRoute::class, 'program']);

// Route::get('/login', [CustomAuthController::class, 'login'])->middleware('alreadyLoggedIn');
// Route::post('/user-login', [CustomAuthController::class, 'loginUser']);
// Route::get('/register', [CustomAuthController::class, 'registration'])->middleware('isLoggedIn');
// Route::post('/register-user', [CustomAuthController::class, 'registerUser']);

// Route::get('/dashboard', [CustomAuthController::class, 'dashboard'])->middleware('isLoggedIn');
// Route::get('/exam-master', [examMaster::class, 'index'])->middleware('isLoggedIn')->name('exam-master.index');
// Route::get('/exam-master/create', [examMaster::class, 'create'])->middleware('isLoggedIn')->name('exam-master.create');
// Route::get('/exam-master/{id}/edit', [examMaster::class, 'edit'])->middleware('isLoggedIn')->name('exam-master.edit');
// Route::put('/exam-master/{id}', [examMaster::class, 'update'])->middleware('isLoggedIn')->name('exam-master.update');
// Route::delete('/exam-master/{id}', [examMaster::class, 'destroy'])->middleware('isLoggedIn')->name('exam-master.destroy');
// Route::post('/exam-master', [examMaster::class, 'store'])->middleware('isLoggedIn')->name('exam-master.store');

// Route::get('/logout', [CustomAuthController::class, 'logout']);
