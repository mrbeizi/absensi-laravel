<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;
use App\Models\Cabang;
use App\Models\PengajuanIzin;
use App\Models\KonfigurasiJamKerja;
use Auth;
use DB;

class PresensiController extends Controller
{
    public function getHari()
    {
        $hari = date("D");
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
        $namaHari    = $this->getHari();
        $nik         = Auth::guard('karyawan')->user()->nik;
        $check       = DB::table('presensis')->where([['tgl_presensi',$today],['nik',$nik]])->count();
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $office_loc  = Cabang::where('kode_cabang',$kode_cabang)->first();
        $jamKerja    = KonfigurasiJamKerja::join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerjas.kode_jam_kerja')->where('nik',$nik)->where('hari',$namaHari)->first();
        return view('presensi.index', compact('check','office_loc','jamKerja'));
    }

    public function store(Request $request)
    {
        $nik          = Auth::guard('karyawan')->user()->nik;
        $kode_cabang  = Auth::guard('karyawan')->user()->kode_cabang;
        $tgl_presensi = date('Y-m-d');
        $jam          = date('H:i:s');
        $lokasi       = $request->lokasi;
        $image        = $request->image;
        $folderPath   = "public/uploads/absensi/";

        $check        = DB::table('presensis')->where([['tgl_presensi',$tgl_presensi],['nik',$nik]])->count();

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
        $namaHari = $this->getHari();
        $jamKerja = KonfigurasiJamKerja::join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerjas.kode_jam_kerja')->where('nik',$nik)->where('hari',$namaHari)->first();

        # Check radius
        if($radius > $office_loc->radius){
            echo "error|Sorry, you're out of radius ".$radius." meters|radius";
        } else {
            if ($check > 0){ # Check data exist or not
                if($jam < $jamKerja->jam_pulang){
                    echo "error|Sorry, it's not time to go home yet!|out";
                } else {
                    $data_pulang = [
                        'jam_out'      => $jam,
                        'foto_out'     => $fileName,
                        'location_out' => $lokasi
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
                        'kode_jam_kerja' => $jamKerja->kode_jam_kerja
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
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->where('nik',$nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.get-history', compact('history'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $datas = DB::table('pengajuan_izins')->where('nik',$nik)->get();
        return view('presensi.izin', compact('datas'));
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

    // Presensi Monitoring
    public function monitoring(Request $request)
    {
        return view('administrator.monitoring.index');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensis')->select('presensis.*','nama_lengkap','karyawans.kode_dept','jam_masuk','nama_jam_kerja','jam_masuk','jam_pulang')
        ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
        ->join('karyawans','karyawans.nik','=','presensis.nik')
        ->join('departments','karyawans.kode_dept','=','departments.kode_dept')
        ->where('tgl_presensi',$tanggal)
        ->get();

        return view('administrator.monitoring.getpresensi', compact('presensi'));
    }

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensis')->where('id',$id)
            ->join('karyawans','presensis.nik','=','karyawans.nik')
            ->first();
        return view('administrator.monitoring.showmap', compact('presensi'));
    }

    public function laporan(Request $request)
    {
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $karyawan = Karyawan::orderBy('nama_lengkap')->get();
        return view('administrator.laporan.index', compact('monthName','karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $karyawan = Karyawan::where('nik',$nik)->join('departments','departments.kode_dept','=','karyawans.kode_dept')->first();
        $presensi = DB::table('presensis')->where('nik',$nik)
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
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
        return view('administrator.laporan.rekap-presensi', compact('monthName'));
    }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $rekap = DB::table('presensis')
            ->selectRaw('presensis.nik, nama_lengkap, jam_masuk, jam_pulang,
                MAX(IF(DAY(tgl_presensi) = 1, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
                MAX(IF(DAY(tgl_presensi) = 2, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
                MAX(IF(DAY(tgl_presensi) = 3, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
                MAX(IF(DAY(tgl_presensi) = 4, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
                MAX(IF(DAY(tgl_presensi) = 5, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
                MAX(IF(DAY(tgl_presensi) = 6, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
                MAX(IF(DAY(tgl_presensi) = 7, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
                MAX(IF(DAY(tgl_presensi) = 8, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
                MAX(IF(DAY(tgl_presensi) = 9, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
                MAX(IF(DAY(tgl_presensi) = 10, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
                MAX(IF(DAY(tgl_presensi) = 11, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
                MAX(IF(DAY(tgl_presensi) = 12, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
                MAX(IF(DAY(tgl_presensi) = 13, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
                MAX(IF(DAY(tgl_presensi) = 14, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
                MAX(IF(DAY(tgl_presensi) = 15, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
                MAX(IF(DAY(tgl_presensi) = 16, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
                MAX(IF(DAY(tgl_presensi) = 17, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
                MAX(IF(DAY(tgl_presensi) = 18, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
                MAX(IF(DAY(tgl_presensi) = 19, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
                MAX(IF(DAY(tgl_presensi) = 20, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
                MAX(IF(DAY(tgl_presensi) = 21, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
                MAX(IF(DAY(tgl_presensi) = 22, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
                MAX(IF(DAY(tgl_presensi) = 23, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
                MAX(IF(DAY(tgl_presensi) = 24, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
                MAX(IF(DAY(tgl_presensi) = 24, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
                MAX(IF(DAY(tgl_presensi) = 25, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
                MAX(IF(DAY(tgl_presensi) = 26, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
                MAX(IF(DAY(tgl_presensi) = 27, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
                MAX(IF(DAY(tgl_presensi) = 28, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
                MAX(IF(DAY(tgl_presensi) = 29, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
                MAX(IF(DAY(tgl_presensi) = 30, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
                MAX(IF(DAY(tgl_presensi) = 31, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_31')
            ->join('karyawans','karyawans.nik','=','presensis.nik')
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->groupBy('presensis.nik','nama_lengkap','jam_masuk','jam_pulang')
            ->get();

            if(isset($_POST['exportexcel'])) {
                $time = date("H:i:s");
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Rekap Presensi $time.xls");
            }

        return view('administrator.laporan.cetakrekap', compact('bulan','tahun','monthName','rekap'));
    }

    public function dataizinsakit(Request $request)
    {
        $query = PengajuanIzin::query();
        $query->select('id','tgl_izin','pengajuan_izins.nik','nama_lengkap','jabatan','status','status_approved','keterangan');
        $query->join('karyawans','karyawans.nik','=','pengajuan_izins.nik');

        if(!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin',[$request->dari, $request->sampai]);
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

        $query->orderBy('tgl_izin','desc');
        $dataizin = $query->paginate(10);
        $dataizin->appends($request->all());
        return view('administrator.data-pengajuan-izin.index', compact('dataizin'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approve = $request->status_approved;
        $update = DB::table('pengajuan_izins')->where('id',$request->idizinsakit)->update([
            'status_approved' => $status_approve
        ]);

        if($update){
            return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
        }else{
            return redirect()->back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function batalkanizinsakit($id)
    {
        $update = DB::table('pengajuan_izins')->where('id',$id)->update([
            'status_approved' => 0
        ]);

        if($update){
            return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
        }else{
            return redirect()->back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function cekdatapengajuanizin(Request $request)
    {
        $tgl = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = PengajuanIzin::where('nik',$nik)->where('tgl_izin',$tgl)->count();
        return $cek;
    }
}
