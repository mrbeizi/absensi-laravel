<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;
use App\Models\Cabang;
use App\Models\Department;
use App\Models\PengajuanIzin;
use App\Models\KonfigurasiJamKerja;
use App\Models\KonfigurasiJamKerjaDepartmentDetail;
use App\Models\User;
use App\Models\HariLibur;
use Auth;
use DB;

class PresensiController extends Controller
{
    public function getHari($hari)
    {
        // $hari = date("D");
        switch ($hari) {
            case 'Sun':
                $hariIni = "Minggu";
                break;
            
            case 'Mon':
                $hariIni = "Senin";
                break;
            
            case 'Tue':
                $hariIni = "Selasa";
                break;
            
            case 'Wed':
                $hariIni = "Rabu";
                break;
            
            case 'Thu':
                $hariIni = "Kamis";
                break;
            
            case 'Fri':
                $hariIni = "Jumat";
                break;
            
            case 'Sat':
                $hariIni = "Sabtu";
                break;
            
            default:
                $hariIni = "Unknown";
                break;
        }
        return $hariIni;
    }

    public function index()
    {
        $today       = date('Y-m-d');
        $nik         = Auth::guard('karyawan')->user()->nik;

        # pengecekan jadwal lintas hari
        $prevDay     = date('Y-m-d', strtotime("-1 days", strtotime($today)));
        $nowHours    = date('H:i');
        
        # pengecekan presensi hari sebelumnya
        $checkPre = DB::table('presensis')
            ->join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->where('tgl_presensi',$prevDay)
            ->where('nik',$nik)
            ->first();

        $checkLintasHari = $checkPre != null ? $checkPre->lintas_hari : 0;

        if($checkLintasHari == '1') {
            if($nowHours < "08:00") { # Ini fleksibel disesuaikan dengan pengaturan jam kerja
                $today = $prevDay;
            }
        }

        $namaHari    = $this->getHari(date('D', strtotime($today)));

        $kode_dept   = Auth::guard('karyawan')->user()->kode_dept;
        $pres        = DB::table('presensis')->where([['tgl_presensi',$today],['nik',$nik]]);        
        $check       = $pres->count();
        $datapres    = $pres->first();

        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $office_loc  = Cabang::where('kode_cabang',$kode_cabang)->first();

        # pengecekan jadwal kerja berdasarkan tanggal
        $jamKerja = DB::table('konfigurasi_jam_kerja_pertanggals')
            ->join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerja_pertanggals.kode_jam_kerja')
            ->where('nik',$nik)
            ->where('tanggal',$today)
            ->first();
        
        # jika kosong, lanjut pengecekan jadwal berdasarkan hari
        if($jamKerja == null){
            $jamKerja    = KonfigurasiJamKerja::join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerjas.kode_jam_kerja')
                ->where('nik',$nik)
                ->where('hari',$namaHari)
                ->first();

            # pengecekan jadwal kerja tiap departemen
            if($jamKerja == null) {
                $jamKerja = KonfigurasiJamKerjaDepartmentDetail::join('konfigurasi_jam_kerja_departments','konfigurasi_jam_kerja_departments.kode_jam_kerja_dept','=','konfigurasi_jam_kerja_department_details.kode_jam_kerja_dept')
                    ->join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerja_department_details.kode_jam_kerja')
                    ->where('kode_dept',$kode_dept)
                    ->where('kode_cabang',$kode_cabang)
                    ->where('hari',$namaHari)
                    ->first();
            }
        }

        if($datapres != null && $datapres->status != "h") {
            return view('presensi.notif-izin');
        } else if($jamKerja == null){
            return view('presensi.notif-jadwal');
        } else {
            return view('presensi.index', compact('check','office_loc','jamKerja','today'));
        }
    }

    public function store(Request $request)
    {
        $nik          = Auth::guard('karyawan')->user()->nik;
        $status_loc   = Auth::guard('karyawan')->user()->status_loc;

        $today       = date('Y-m-d');

        # pengecekan jadwal lintas hari
        $prevDay     = date('Y-m-d', strtotime("-1 days", strtotime($today)));
        $nowHours    = date('H:i');

        # pengecekan presensi hari sebelumnya
        $checkPre = DB::table('presensis')
            ->join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->where('tgl_presensi',$prevDay)
            ->where('nik',$nik)
            ->first();

        $checkLintasHari = $checkPre != null ? $checkPre->lintas_hari : 0;

        $kode_dept    = Auth::guard('karyawan')->user()->kode_dept;
        $kode_cabang  = Auth::guard('karyawan')->user()->kode_cabang;
        $tgl_presensi = $checkLintasHari == '1' && $nowHours < "08:00" ? $prevDay : date('Y-m-d');
        $jam          = date('H:i:s');
        $lokasi       = $request->lokasi;
        $image        = $request->image;
        $folderPath   = "public/uploads/absensi/";

        $presensi     = DB::table('presensis')->where([['tgl_presensi',$tgl_presensi],['nik',$nik]]);
        $check        = $presensi->count();
        $datapresensi = $presensi->first();

        # To store different file name
        if($check > 0) {
            $writeName = "out";
        } else {
            $writeName = "in";
        }

        $formatName   = $nik."-".$tgl_presensi."-".$writeName;
        $image_parts  = explode(";base64",$image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName     = $formatName.".png";
        $file         = $folderPath.$fileName;

        # Data Radius
        $office_loc = Cabang::where('kode_cabang',$kode_cabang)->first();
        $exp_office_loc = explode(",",$office_loc->lokasi_kantor);
        $latOffice  = $exp_office_loc[0];
        $longOffice = $exp_office_loc[1];

        $locUser    = explode(",",$lokasi);
        $latUser    = $locUser[0]; 
        $longUser   = $locUser[1];

        $dis    = $this->distance($latOffice,$longOffice,$latUser,$longUser);
        $radius = round($dis["meters"]);  
        
        # Cek Jam Kerja
        $namaHari = $this->getHari(date('D', strtotime($tgl_presensi)));

        # pengecekan jadwal kerja berdasarkan tanggal
        $jamKerja = DB::table('konfigurasi_jam_kerja_pertanggals')
            ->join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerja_pertanggals.kode_jam_kerja')
            ->where('nik',$nik)
            ->where('tanggal',$today)
            ->first();

        # jika kosong, lanjut pengecekan jadwal berdasarkan hari
        if($jamKerja == null){
            $jamKerja = KonfigurasiJamKerja::join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerjas.kode_jam_kerja')
                ->where('nik',$nik)
                ->where('hari',$namaHari)
                ->first();

            # jika kosong, lanjut pengecekan jadwal kerja tiap departemen            
            if($jamKerja == null) {
                $jamKerja = KonfigurasiJamKerjaDepartmentDetail::join('konfigurasi_jam_kerja_departments','konfigurasi_jam_kerja_departments.kode_jam_kerja_dept','=','konfigurasi_jam_kerja_department_details.kode_jam_kerja_dept')
                    ->join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerja_department_details.kode_jam_kerja')
                    ->where('kode_dept',$kode_dept)
                    ->where('kode_cabang',$kode_cabang)
                    ->where('hari',$namaHari)
                    ->first();
            }
        }

        # pengecekan jadwal lintas hari
        $tgl_pulang = $jamKerja->lintas_hari == '1' ? date('Y-m-d', strtotime("+ 1 days", strtotime($tgl_presensi))) : $tgl_presensi;
        $jam_pulang = $today . "" . $jam;
        $jamker_pulang = $tgl_pulang . "" . $jamKerja->jam_pulang;

        # Check radius and status location (lock or unlock)
        if($status_loc == '1' && $radius > $office_loc->radius){
            echo "error|Sorry, you're out of radius ".$radius." meters|radius";
        } else {
            if ($check > 0){ # Check data exist or not
                if($jam_pulang < $jamker_pulang){
                    echo "error|Sorry, it's not time to go home yet!|out";
                } else if(!empty($datapresensi->jam_out)) {
                    echo "error|Sorry, you have checked out!|out";
                } else {
                    $data_pulang = [
                        'jam_out'      => $jam,
                        'foto_out'     => $fileName,
                        'location_out' => $lokasi,
                        'updated_at'   => now()
                    ];
                    $post = DB::table('presensis')->where([['tgl_presensi',$tgl_presensi],['nik',$nik]])->update($data_pulang);
                    if($post){
                        echo "success|Good bye, take care!|out";
                        Storage::put($file,$image_base64);
                    } else {
                        echo "error|Oops, data failed to save!|out";
                    }
                }
            } else {
                if($jam < $jamKerja->awal_jam_masuk){
                    echo "error|Sorry, you come too early!|in";
                } else if($jam > $jamKerja->akhir_jam_masuk){
                    echo "error|Sorry, time to presence is over!|in";
                } else {
                    $data_masuk = [
                        'nik'          => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_in'       => $jam,
                        'foto_in'      => $fileName,
                        'location_in'  => $lokasi,
                        'kode_jam_kerja' => $jamKerja->kode_jam_kerja,
                        'status'       => 'h',
                        'created_at'   => now(),
                        'updated_at'   => now()
                    ];
                    $post = DB::table('presensis')->insert($data_masuk);
                    if($post){
                        echo "success|Thank you, happy working!|in";
                        Storage::put($file,$image_base64);
                    } else {
                        echo "error|Oops, data failed to save!|in";
                    }
                }
            }
        }

    }

    # Count the Radius
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta      = $lon1 - $lon2;
        $miles      = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles      = acos($miles);
        $miles      = rad2deg($miles);
        $miles      = $miles * 60 * 1.1515;
        $feet       = $miles * 5280;
        $yards      = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters     = $kilometers * 1000;
        return compact('meters');
    }

    # Edit Profile
    public function editProfile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $staf = DB::table('karyawans')->where('nik',$nik)->first();
        return view('presensi.edit-profile', compact('staf'));
    }

    public function updateProfile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        # Get previous photo in database, if photo is not updated
        $getData = DB::table('karyawans')->where('nik',$nik)->first();

        $request->validate([
            'foto' => 'image|mimes:png,jpg'
        ]);

        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $getData->foto;
        }

        if(!empty($request->password)){
            $post = [
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'password' => Hash::make($request->password),
                'foto' => $foto,
            ];
            
        } else {
            $post = [
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'foto' => $foto,
            ];
        }

        $update = DB::table('karyawans')->where('nik',Auth::guard('karyawan')->user()->nik)->update($post);
        if($update){
            # Store the updated photo
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()->back()->with(['success' => 'Data berhasil diubah!']);
        } else {
            return redirect()->back()->with(['error' => 'Data gagal diubah!']);
        }
    }

    public function history()
    {
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return view('presensi.history', compact('monthName'));
    }

    public function getHistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $history = DB::table('presensis')
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->leftJoin('pengajuan_izins','pengajuan_izins.kode_izin','=','presensis.kode_izin')
            ->leftJoin('master_cutis','master_cutis.kode_cuti','=','pengajuan_izins.kode_cuti')
            ->select('presensis.*','jam_kerjas.*','pengajuan_izins.keterangan','docs_sid','nama_cuti')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->where('presensis.nik',$nik)
            ->orderBy('tgl_presensi','DESC')
            ->get();

        return view('presensi.get-history', compact('history'));
    }

    public function izin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        if(!empty($request->bulan) && !empty($request->tahun)){
            $datas = DB::table('pengajuan_izins')
                ->leftJoin('master_cutis','master_cutis.kode_cuti','=','pengajuan_izins.kode_cuti')
                ->select('pengajuan_izins.*','master_cutis.nama_cuti')
                ->where('nik',$nik)
                ->whereRaw('MONTH(tgl_izin_dari)="'.$request->bulan.'"')
                ->whereRaw('YEAR(tgl_izin_dari)="'.$request->tahun.'"')
                ->orderBy('tgl_izin_dari','desc')
                ->get();
        } else {
            $datas = DB::table('pengajuan_izins')
                ->leftJoin('master_cutis','master_cutis.kode_cuti','=','pengajuan_izins.kode_cuti')
                ->select('pengajuan_izins.*','master_cutis.nama_cuti')
                ->where('nik',$nik)
                ->orderBy('tgl_izin_dari','desc')
                ->limit(5)->latest()->get();
        }

        
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return view('presensi.izin', compact('datas','monthName'));
    }

    public function createizin()
    {
        return view('presensi.create-izin');
    }

    public function storeizin(Request $request)
    {
        $post = DB::table('pengajuan_izins')->insert([
            'nik' => Auth::guard('karyawan')->user()->nik,
            'tgl_izin' => $request->tgl_izin,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'status_approved' => 0
        ]);

        if($post){
            return redirect()->route('presensi-izin')->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect()->route('presensi-izin')->with(['error' => 'Data gagal disimpan!']);
        }
    }

    public function deletedataizin($kode_izin)
    {
        $check = DB::table('pengajuan_izins')->where('kode_izin',$kode_izin)->first();
        $docs_sid = $check->docs_sid;

        try {
            DB::table('pengajuan_izins')->where('kode_izin',$kode_izin)->delete();
            if($docs_sid != null){
                Storage::delete('/public/uploads/sid/'.$docs_sid);
            }
            return redirect()->route('presensi-izin')->with(['success' => 'Data berhasil dihapus!']);
        } catch (\Exception $e) {
            return redirect()->route('presensi-izin')->with(['error' => 'Data gagal dihapus!']);
        }
    }

    // Presensi Monitoring
    public function monitoring(Request $request)
    {
        $department = Department::orderBy('kode_dept')->get();
        $cabang = Cabang::orderBy('nama_cabang')->get();
        return view('administrator.monitoring.index', compact('department','cabang'));
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;

        $query = Karyawan::query();
        $query->selectRaw('karyawans.nik, nama_lengkap, karyawans.kode_dept, karyawans.kode_cabang, data.id, jam_in, jam_out, foto_in, foto_out, location_in, location_out, data.status, jam_masuk, nama_jam_kerja, jam_pulang, keterangan');
        $query->leftJoin(
            DB::raw("(
            SELECT presensis.nik, presensis.id, jam_in, jam_out, foto_in, foto_out, location_in, location_out, presensis.status, jam_masuk, nama_jam_kerja, jam_pulang, keterangan
            FROM presensis 
            LEFT JOIN jam_kerjas ON presensis.kode_jam_kerja = jam_kerjas.kode_jam_kerja 
            LEFT JOIN pengajuan_izins ON presensis.kode_izin = pengajuan_izins.kode_izin WHERE tgl_presensi = '$tanggal'
            ) data"),
            function ($join) {
                $join->on('karyawans.nik','=','data.nik');
            }
        );

        if(!empty($request->kode_dept)){
            $query->where('karyawans.kode_dept', $request->kode_dept);
        }
        if(!empty($request->kode_cabang)){
            $query->where('karyawans.kode_cabang', $request->kode_cabang);
        }

        $query->orderBy('nama_lengkap');
        $presensi = $query->get();

        return view('administrator.monitoring.getpresensi', compact('presensi','tanggal'));
    }

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensis')->where('id',$id)
            ->join('karyawans','presensis.nik','=','karyawans.nik')
            ->first();
        return view('administrator.monitoring.showmap', compact('presensi'));
    }

    public function tampilkankoreksi(Request $request)
    {
        $nik = $request->nik;
        $karyawan = Karyawan::where('nik',$nik)->first();
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensis')->where('nik',$karyawan->nik)->where('tgl_presensi',$tanggal)->first();
        $jamkerja = DB::table('jam_kerjas')->orderBy('kode_jam_kerja')->get();
        return view('administrator.monitoring.showkoreksi', compact('karyawan','tanggal','jamkerja','presensi'));
    }

    public function simpankoreksi(Request $request)
    {
        $nik = $request->nik;
        $tanggal = $request->tanggal;
        $status = $request->status;
        $jam_in = $status == "a" ? null : $request->jam_in;
        $jam_out = $status == "a" ? null : $request->jam_out;
        $kode_jam_kerja = $status == "a" ? null : $request->kode_jam_kerja;
        
        try {
            $checkpresensi = DB::table('presensis')->where('nik',$nik)->where('tgl_presensi',$tanggal)->count();
            if($checkpresensi > 0) {
                DB::table('presensis')->where('nik',$nik)->where('tgl_presensi',$tanggal)->update([
                    'jam_in' => $jam_in,
                    'jam_out' => $jam_out,
                    'kode_jam_kerja' => $kode_jam_kerja,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('presensis')->insert([
                    'nik' => $nik,
                    'tgl_presensi' => $tanggal,
                    'jam_in' => $jam_in,
                    'jam_out' => $jam_out,
                    'kode_jam_kerja' => $kode_jam_kerja,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            return redirect()->back()->with(['success' => 'Data berhasil dikoreksi']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['warning' => 'Data gagal dikoreksi']);
        }
    }

    public function laporan(Request $request)
    {
        # menerapkan role
        $getKodeDept = Auth::guard('user')->user()->kode_dept;
        $getKodeCabang = Auth::guard('user')->user()->kode_cabang;
        $getUser = User::find(Auth::guard('user')->user()->id);

        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        if($getUser->hasRole('Admin Departemen')){
            $karyawan = Karyawan::where('kode_dept',$getKodeDept)->where('kode_cabang',$getKodeCabang)->orderBy('nama_lengkap')->get();
        } else {
            $karyawan = Karyawan::orderBy('nama_lengkap')->get();
        }
        return view('administrator.laporan.index', compact('monthName','karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $karyawan = Karyawan::where('nik',$nik)->join('departments','departments.kode_dept','=','karyawans.kode_dept')->first();
        $presensi = DB::table('presensis')->where('presensis.nik',$nik)
            ->select('presensis.*','jam_kerjas.*','pengajuan_izins.keterangan')
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->leftJoin('pengajuan_izins','pengajuan_izins.kode_izin','=','presensis.kode_izin')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->orderBy('tgl_presensi')
            ->get();

            if(isset($_POST['exportexcel'])) {
                $time = date("H:i:s");
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laporan Presensi $time.xls");
            }

        return view('administrator.laporan.cetaklaporan', compact('bulan','tahun','monthName','karyawan','presensi'));
    }

    public function rekap(Request $request)
    {
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $getDepartment = Department::all();
        $cabang = Cabang::orderBy('nama_cabang')->get();
        return view('administrator.laporan.rekap-presensi', compact('monthName','getDepartment','cabang'));
    }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kodeDept = $request->kode_dept;
        $kodeCabang = $request->kode_cabang;
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $dari = sprintf("%d-%02d-01", $tahun, $bulan);
        $sampai = date('Y-m-t', strtotime($dari));

        // Mencari data libur karyawan
        $datalibur = getHariLiburKaryawan($dari, $sampai);
        $ketlibur = HariLibur::whereBetween('tgl_libur',[$dari, $sampai])->get();

        // Membuat array tanggal dari awal hingga akhir bulan
        $rangeTanggal = [];
        $tempTanggal = $dari;
        while (strtotime($tempTanggal) <= strtotime($sampai)) {
            $rangeTanggal[] = $tempTanggal;
            $tempTanggal = date("Y-m-d", strtotime("+1 day", strtotime($tempTanggal)));
        }

        $jumlahHari = date('t', strtotime($dari));

        $query = Karyawan::query();
        $query->selectRaw("karyawans.nik, nama_lengkap, jabatan");

        // Tambahkan kolom tanggal secara dinamis dengan prepared statements
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $query->selectRaw("MAX(IF(tgl_presensi = ?, 
                CONCAT(
                    IFNULL(jam_in,'NA'),'|',
                    IFNULL(jam_out,'NA'),'|',
                    IFNULL(presensis.status,'NA'),'|',
                    IFNULL(nama_jam_kerja,'NA'),'|',
                    IFNULL(jam_masuk,'NA'),'|',
                    IFNULL(jam_pulang,'NA'),'|',
                    IFNULL(presensis.kode_izin,'NA'),'|',
                    IFNULL(keterangan,'NA'),'|'
                ),NULL)) as tgl_$i", [$rangeTanggal[$i - 1]]);
        }

        // Gunakan subquery dengan GROUP BY yang benar
        $query->leftJoin(DB::raw("
            (SELECT 
                presensis.nik, 
                presensis.tgl_presensi, 
                MAX(jam_in) AS jam_in, 
                MAX(jam_out) AS jam_out, 
                MAX(presensis.status) AS status, 
                MAX(nama_jam_kerja) AS nama_jam_kerja, 
                MAX(jam_masuk) AS jam_masuk, 
                MAX(jam_pulang) AS jam_pulang, 
                MAX(presensis.kode_izin) AS kode_izin, 
                MAX(keterangan) AS keterangan 
            FROM presensis 
            LEFT JOIN jam_kerjas ON jam_kerjas.kode_jam_kerja = presensis.kode_jam_kerja 
            LEFT JOIN pengajuan_izins ON pengajuan_izins.kode_izin = presensis.kode_izin 
            WHERE tgl_presensi BETWEEN ? AND ?
            GROUP BY presensis.nik, presensis.tgl_presensi
            ) presensis"),
            function ($join) use ($dari, $sampai) {
                $join->on('karyawans.nik', '=', 'presensis.nik');
            }
        )->setBindings([$dari, $sampai]);

        $query->groupBy('karyawans.nik', 'karyawans.nama_lengkap', 'karyawans.jabatan');

        if(!empty($kodeDept)) {
            $query->where('kode_dept',$kodeDept);
        }

        if(!empty($kodeCabang)) {
            $query->where('kode_cabang',$kodeCabang);
        }

        $query->orderBy('nama_lengkap');
        $rekap = $query->get();
        

            if(isset($_POST['exportexcel'])) {
                $time = date("H:i:s");
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Rekap Presensi $time.xls");
            }

        return view('administrator.laporan.cetakrekap', compact('bulan','tahun','monthName','rekap','rangeTanggal','jumlahHari','datalibur','ketlibur'));
    }

    public function dataizinsakit(Request $request)
    {
        # menerapkan role
        $getKodeDept = Auth::guard('user')->user()->kode_dept;
        $getKodeCabang = Auth::guard('user')->user()->kode_cabang;
        $getUser = User::find(Auth::guard('user')->user()->id);

        $query = PengajuanIzin::query();
        $query->select('kode_izin','tgl_izin_dari','tgl_izin_sampai','pengajuan_izins.nik','docs_sid','nama_lengkap','jabatan','status','status_approved','keterangan','karyawans.kode_dept','karyawans.kode_cabang');
        $query->join('karyawans','karyawans.nik','=','pengajuan_izins.nik');

        if(!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin_dari',[$request->dari, $request->sampai]);
        }

        if(!empty($request->nik)){
            $query->where('pengajuan_izins.nik',$request->nik);
        }

        if(!empty($request->nama_lengkap)){
            $query->where('karyawans.nama_lengkap','like', '%'.$request->nama_lengkap.'%');
        }

        if($request->status_approved === "0" || $request->status_approved === "1" || $request->status_approved === "2"){
            $query->where('pengajuan_izins.status_approved',$request->status_approved);
        }

        if(!empty($request->kode_dept)){
            $query->where('karyawans.kode_dept',$request->kode_dept);
        }

        if(!empty($request->kode_cabang)){
            $query->where('karyawans.kode_cabang',$request->kode_cabang);
        }

        if($getUser->hasRole('Admin Departemen')) {
            $query->where('karyawans.kode_dept',$getKodeDept);
            $query->where('karyawans.kode_cabang',$getKodeCabang);
        }

        $query->orderBy('tgl_izin_dari','desc');
        $dataizin = $query->paginate(10);
        $dataizin->appends($request->all());

        $department = Department::orderBy('kode_dept')->get();
        $cabang = Cabang::orderBy('nama_cabang')->get();
        return view('administrator.data-pengajuan-izin.index', compact('dataizin','department','cabang'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approve = $request->status_approved;
        $dataizin = DB::table('pengajuan_izins')->where('kode_izin',$request->idizinsakit)->first();
        $nik = $dataizin->nik;
        $izindari = $dataizin->tgl_izin_dari;
        $izinsampai = $dataizin->tgl_izin_sampai;
        $status = $dataizin->status;

        DB::beginTransaction();
        try {
            if($status_approve == 1){
                while(strtotime($izindari) <= strtotime($izinsampai)){
                    DB::table('presensis')->insert([
                        'nik' => $nik,
                        'tgl_presensi' => $izindari,
                        'status' => $status,
                        'kode_izin' => $request->idizinsakit,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $izindari = date("Y-m-d", strtotime("+1 days", strtotime($izindari)));
                }
            }
            DB::table('pengajuan_izins')->where('kode_izin',$request->idizinsakit)->update([
                'status_approved' => $status_approve,
                'updated_at' => now()
            ]);
            DB::commit();
            return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function batalkanizinsakit($kode_izin)
    {
        DB::beginTransaction();
        try {
            DB::table('pengajuan_izins')->where('kode_izin',$kode_izin)->update([
                'status_approved' => 0
            ]);
            DB::table('presensis')->where('kode_izin',$kode_izin)->delete();
            DB::commit();
            return redirect()->back()->with(['success' => 'Data berhasil dibatalkan']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['warning' => 'Data gagal dibatalkan']);
        }
    }

    public function cekdatapengajuanizin(Request $request)
    {
        $tgl = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = PengajuanIzin::where('nik',$nik)->where('tgl_izin',$tgl)->count();
        return $cek;
    }

    public function showact($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izins')->where('kode_izin',$kode_izin)->first();
        return view('presensi.showact', compact('dataizin'));
    }
}
