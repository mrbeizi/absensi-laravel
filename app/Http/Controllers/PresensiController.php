<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class PresensiController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $nik   = Auth::guard('karyawan')->user()->nik;
        $check = DB::table('presensis')->where([['tgl_presensi',$today],['nik',$nik]])->count();
        return view('presensi.index', compact('check'));
    }

    public function store(Request $request)
    {
        $nik          = Auth::guard('karyawan')->user()->nik;
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
        $latOffice  = 1.1281765;
        $longOffice = 104.0332504;
        $locUser    = explode(",",$lokasi);
        $latUser    = $locUser[0]; 
        $longUser   = $locUser[1];

        $dis    = $this->distance($latOffice,$longOffice,$latUser,$longUser);
        $radius = round($dis["meters"]);        

        # Check radius
        if($radius > 120){
            echo "error|Sorry, you're out of radius ".$radius." meters|radius";
        } else {
            # Check data exist or not
            if($check > 0){
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
            } else {
                $data_masuk = [
                    'nik'          => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in'       => $jam,
                    'foto_in'      => $fileName,
                    'location_in'  => $lokasi
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
        $monthName = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
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
        return view('presensi.izin');
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
}
