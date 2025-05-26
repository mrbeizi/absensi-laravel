<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KonfigurasiController;

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

Route::middleware(['guest:user'])->group(function(){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');   
    Route::post('/proses-login-admin',[AuthController::class,'prosesLoginAdmin'])->name('proses-login-admin');
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proses-logout-admin',[AuthController::class,'prosesLogoutAdmin'])->name('proses-logout-admin');
    Route::get('/panel/dashboardadmin', [DashboardController::class,'dashboardadmin'])->name('dashboardadmin');

    // Karyawan
    Route::get('/karyawan',[KaryawanController::class, 'index'])->name('index-karyawan');
    Route::post('/karyawan/store',[KaryawanController::class,'simpan']);
    Route::post('/karyawan/edit',[KaryawanController::class,'edit']);
    Route::post('/karyawan/{nik}/update',[KaryawanController::class,'update']);
    Route::post('/karyawan/{nik}/destroy',[KaryawanController::class,'destroy']);

    // Department
    Route::get('/department',[DepartmentController::class, 'index'])->name('index-department');
    Route::post('/department/store',[DepartmentController::class,'simpan']);
    Route::post('/department/edit',[DepartmentController::class,'edit']);
    Route::post('/department/{kode_dept}/update',[DepartmentController::class,'update']);
    Route::post('/department/{kode_dept}/destroy',[DepartmentController::class,'destroy']);

    // Presensi Monitoring
    Route::get('presensi-monitoring',[PresensiController::class,'monitoring'])->name('presensi-monitoring');
    Route::post('get-presensi',[PresensiController::class,'getpresensi'])->name('get-presensi');
    Route::post('tampilkan-peta',[PresensiController::class,'tampilkanpeta'])->name('tampilkan-peta');

    // Laporan Presensi
    Route::get('laporan-presensi',[PresensiController::class, 'laporan'])->name('laporan-presensi');
    Route::post('cetaklaporan-presensi',[PresensiController::class, 'cetaklaporan'])->name('cetaklaporan-presensi');
    Route::get('rekap-presensi',[PresensiController::class, 'rekap'])->name('rekap-presensi');
    Route::post('cetakrekap-presensi',[PresensiController::class, 'cetakrekap'])->name('cetakrekap-presensi');

    // Konfigurasi
    Route::get('lokasi-kantor',[KonfigurasiController::class, 'lokasikantor'])->name('lokasi-kantor');
    Route::post('update-lokasi-kantor',[KonfigurasiController::class, 'updatelokasikantor'])->name('update-lokasi-kantor');
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

    # izin
    Route::get('/presensi-izin',[PresensiController::class,'izin'])->name('presensi-izin');
    Route::get('/presensi-izin/create',[PresensiController::class,'createizin'])->name('create-izin');
    Route::post('/presensi-izin/store',[PresensiController::class,'storeizin'])->name('store-izin');
});