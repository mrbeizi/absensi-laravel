<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;

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

Route::middleware(['guest:karyawan'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');    
    Route::post('/proses-login',[AuthController::class,'prosesLogin'])->name('proses-login');
});

Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/proses-logout',[AuthController::class,'prosesLogout'])->name('proses-logout');
    Route::get('/camera',[PresensiController::class,'index'])->name('camera');
    Route::post('/camera-snap',[PresensiController::class,'store'])->name('camera-snap');

    # edit profile
    Route::get('/edit-profile',[PresensiController::class,'editProfile'])->name('edit-profile');
    Route::post('/update/{nik}/profile',[PresensiController::class,'updateProfile']);

    # history
    Route::get('/presensi-history',[PresensiController::class,'history'])->name('presensi-history');
    Route::post('/get-history',[PresensiController::class,'getHistory'])->name('get-history');
});