<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\KantorCabangController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\MasterCutiController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

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

    // Data user
    Route::get('/data-user',[UserController::class, 'index'])->name('data-user');
    Route::post('/data-user/store',[UserController::class,'simpan']);
    Route::post('/data-user/edit',[UserController::class,'edit']);
    Route::post('/data-user/{id}/update',[UserController::class,'update']);
    Route::post('/data-user/{id}/destroy',[UserController::class,'destroy']);

    // Karyawan
    Route::get('/karyawan',[KaryawanController::class, 'index'])->name('index-karyawan');
    Route::post('/karyawan/store',[KaryawanController::class,'simpan']);
    Route::post('/karyawan/edit',[KaryawanController::class,'edit']);
    Route::post('/karyawan/{nik}/update',[KaryawanController::class,'update']);
    Route::post('/karyawan/{nik}/destroy',[KaryawanController::class,'destroy']);
    Route::get('/karyawan/{nik}/resetpassword',[KaryawanController::class,'resetpassword']);
    Route::get('karyawan/{nik}/switch-location',[KaryawanController::class, 'switchlocation'])->name('switch-status-loc');

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
    Route::post('koreksi-presensi',[PresensiController::class,'tampilkankoreksi'])->name('koreksi-presensi');
    Route::post('koreksi-presensi-store',[PresensiController::class,'simpankoreksi'])->name('koreksi-presensi-store');

    // Laporan Presensi
    Route::get('laporan-presensi',[PresensiController::class, 'laporan'])->name('laporan-presensi');
    Route::post('cetaklaporan-presensi',[PresensiController::class, 'cetaklaporan'])->name('cetaklaporan-presensi');
    Route::get('rekap-presensi',[PresensiController::class, 'rekap'])->name('rekap-presensi');
    Route::post('cetakrekap-presensi',[PresensiController::class, 'cetakrekap'])->name('cetakrekap-presensi');

    // Izin Sakit Cuti
    Route::get('data-pengajuan-izin',[PresensiController::class, 'dataizinsakit'])->name('data-izinsakit');
    Route::post('approve-izinsakit',[PresensiController::class, 'approveizinsakit'])->name('approve-izinsakit');
    Route::get('presensi/{kode_izin}/batalkanizinsakit',[PresensiController::class,'batalkanizinsakit']);
    

    // Konfigurasi
    Route::get('lokasi-kantor',[KonfigurasiController::class, 'lokasikantor'])->name('lokasi-kantor');
    Route::post('update-lokasi-kantor',[KonfigurasiController::class, 'updatelokasikantor'])->name('update-lokasi-kantor');

    // Kantor Cabang
    Route::get('/kantorcabang',[KantorCabangController::class, 'index'])->name('index-kantorcabang');
    Route::post('/kantorcabang/store',[KantorCabangController::class,'simpan']);
    Route::post('/kantorcabang/edit',[KantorCabangController::class,'edit']);
    Route::post('/kantorcabang/{kode_cabang}/update',[KantorCabangController::class,'update']);
    Route::post('/kantorcabang/{kode_cabang}/destroy',[KantorCabangController::class,'destroy']);

    // Jam Kerja
    Route::get('/jamkerja',[KonfigurasiController::class,'jamkerja'])->name('jam-kerja');
    Route::post('/jamkerja/store',[KonfigurasiController::class,'simpanjamkerja']);
    Route::post('/jamkerja/edit',[KonfigurasiController::class,'editjamkerja']);
    Route::post('/jamkerja/{kode_jamker}/destroy',[KonfigurasiController::class,'destroyjamker']);
    Route::post('/jamkerja/simpan-pertanggal',[KonfigurasiController::class, 'simpanpertanggal'])->name('simpan-pertanggal');
    Route::get('/jamkerja/{nik}/{bulan}/{tahun}/show',[KonfigurasiController::class, 'showpertanggal']);
    Route::post('/jamkerja/hapus',[KonfigurasiController::class, 'hapuspertanggal'])->name('hapuspertanggal');

    // Setting Jam Kerja
    Route::get('/karyawan/{nik}/setjamkerja',[KonfigurasiController::class,'setjamkerja']);
    Route::post('/konfigurasi/storesetjamkerja',[KonfigurasiController::class,'storesetjamkerja']);
    Route::post('/konfigurasi/updatesetjamkerja',[KonfigurasiController::class,'updatesetjamkerja']);

    // Jam Kerja Departemen
    Route::get('/jamkerjadepartment',[KonfigurasiController::class,'jamkerjadept'])->name('jam-kerja-department');
    Route::post('/jamkerjadepartment/store',[KonfigurasiController::class,'simpanjamkerjadepartment']);
    Route::post('/jamkerjadepartment/edit',[KonfigurasiController::class,'editjamkerjadepartment']);
    Route::post('/jamkerjadepartment/{kode_jamker_dept}/destroy',[KonfigurasiController::class,'destroyjamkerdepartment']);
    Route::post('/showjadwaljamkerjadept',[KonfigurasiController::class,'showjadwaljamkerdepartment'])->name('show-jadwal-jamker-dept');

    // Master Cuti
    Route::get('master-cuti',[MasterCutiController::class, 'index'])->name('index-mastercuti');
    Route::post('/master-cuti/store',[MasterCutiController::class,'simpanmastercuti']);
    Route::post('/master-cuti/edit',[MasterCutiController::class,'editmastercuti']);
    Route::post('/master-cuti/{kode_cuti}/destroy',[MasterCutiController::class,'destroymastercuti']);

    // Hari Libur
    Route::get('hari-libur',[KonfigurasiController::class,'harilibur'])->name('hari-libur');
    Route::post('/hari-libur/store',[KonfigurasiController::class,'simpanharilibur']);
    Route::post('/hari-libur/edit',[KonfigurasiController::class,'editharilibur']);
    Route::post('/hari-libur/{kode_libur}/update',[KonfigurasiController::class,'updateharilibur']);
    Route::post('/hari-libur/{kode_libur}/destroy',[KonfigurasiController::class,'hapusharilibur']);
    Route::get('/hari-libur/setharilibur/{kode_libur}/karyawan',[KonfigurasiController::class,'setharilibur']);
    Route::get('/hari-libur/setharilibur/{kode_libur}/listkaryawan',[KonfigurasiController::class,'setlistkaryawanlibur']);
    Route::get('/hari-libur/setharilibur/{kode_libur}/getlistkaryawan',[KonfigurasiController::class,'getlistkaryawanlibur']);
    Route::post('/hari-libur/setharilibur/simpankaryawanlibur',[KonfigurasiController::class,'simpankaryawanlibur'])->name('simpan-karyawan-libur');
    Route::post('/hari-libur/setharilibur/hapuskaryawanlibur',[KonfigurasiController::class,'hapuskaryawanlibur'])->name('hapus-karyawan-libur');
    Route::get('/hari-libur/setharilibur/{kode_libur}/getkaryawanlibur',[KonfigurasiController::class,'getkaryawanlibur']);
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

    Route::post('cekdata-pengajuan-izin',[PresensiController::class, 'cekdatapengajuanizin'])->name('cekdata-pengajuan-izin');

    # Perizinan
    Route::get('/izinabsen',[PerizinanController::class, 'indexizinabsen'])->name('index-izinabsen');
    Route::post('/izinabsen/store',[PerizinanController::class,'storeizinabsen'])->name('store-izinabsen');
    Route::get('/izinabsen/{kode_izin}/edit',[PerizinanController::class, 'editizinabsen'])->name('edit-izinabsen');
    Route::post('/izinabsen/{kode_izin}/update',[PerizinanController::class, 'updateizinabsen'])->name('update-izinabsen');
    
    Route::get('/izinsakit',[PerizinanController::class, 'indexizinsakit'])->name('index-izinsakit');
    Route::post('/izinsakit/store',[PerizinanController::class,'storeizinsakit'])->name('store-izinsakit');
    Route::get('/izinsakit/{kode_izin}/edit',[PerizinanController::class, 'editizinsakit'])->name('edit-izinsakit');
    Route::post('/izinsakit/{kode_izin}/update',[PerizinanController::class, 'updateizinsakit'])->name('update-izinsakit');

    Route::get('/izincuti',[PerizinanController::class, 'indexizincuti'])->name('index-izincuti');
    Route::post('/izincuti/store',[PerizinanController::class,'storeizincuti'])->name('store-izincuti');
    Route::get('/izincuti/{kode_izin}/edit',[PerizinanController::class, 'editizincuti'])->name('edit-izincuti');
    Route::post('/izincuti/{kode_izin}/update',[PerizinanController::class, 'updateizincuti'])->name('update-izincuti');
    Route::post('/izincuti/getmaxcuti',[PerizinanController::class,'getmaxcuti'])->name('getmaxcuti');

    Route::get('/izin/{kode_izin}/showact',[PresensiController::class, 'showact']);
    Route::get('/izin/{kode_izin}/delete',[PresensiController::class, 'deletedataizin']);
});