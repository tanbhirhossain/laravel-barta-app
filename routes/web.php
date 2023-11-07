<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserprofileController;
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


//Authorization
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('front.register.store');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class,'login'])->name('front.login.attempt');
Route::get('/logout', [LoginController::class,'logout'])->name('logout');
Route::post('/logout', [LoginController::class,'logout']);

//Home
Route::get('/', [HomeController::class,'index'])->name('front.home');
Route::get('/profile', [UserprofileController::class,'index'])->name('front.profile');
Route::get('/profile/edit', [UserprofileController::class,'edit'])->name('front.profile.edit');
Route::put('/profile/edit', [UserprofileController::class, 'update'])->name('front.profile.update');
