<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

class PresensiController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $check = DB::table('presensis')->where([['tgl_presensi',$today],['nik',$nik]])->count();
        return view('presensi.index', compact('check'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lokasi = $request->lokasi;
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik."-".$tgl_presensi;

        $image_parts = explode(";base64",$image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName.".png";
        $file = $folderPath.$fileName;

        

        $check = DB::table('presensis')->where([['tgl_presensi',$tgl_presensi],['nik',$nik]])->count();
        if($check > 0){
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
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
                'nik' => $nik,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'foto_in' => $fileName,
                'location_in' => $lokasi
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
