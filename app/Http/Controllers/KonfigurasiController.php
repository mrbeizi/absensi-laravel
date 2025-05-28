<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JamKerja;
use DB;

class KonfigurasiController extends Controller
{
    public function lokasikantor(Request $request)
    {
        $office_loc = DB::table('konfigurasi_lokasis')->where('id',1)->first();
        return view('administrator.konfigurasi.lokasikantor', compact('office_loc'));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('konfigurasi_lokasis')->where('id',1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if($update){
            return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function jamkerja(Request $request)
    {
        $jamkerja = JamKerja::all();
        return view('administrator.konfigurasi.jamkerja', compact('jamkerja'));
    }

    public function simpanjamkerja(Request $request)
    {        
        $kode_jamker = $request->kode_jam_kerja;
        $nama_jamker = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;

        try {            
            if($request->hidkodejamker == ""){
                $data = [                
                    'kode_jam_kerja' => $kode_jamker,
                    'nama_jam_kerja' => $nama_jamker,
                    'awal_jam_masuk' => $awal_jam_masuk,
                    'jam_masuk' => $jam_masuk,
                    'akhir_jam_masuk' => $akhir_jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $simpan = JamKerja::insert($data);
                if($simpan) {
                    return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
                }
            } else {
                $simpan = JamKerja::where('kode_jam_kerja',$request->hidkodejamker)->update([
                    'nama_jam_kerja' => $nama_jamker,
                    'awal_jam_masuk' => $awal_jam_masuk,
                    'jam_masuk' => $jam_masuk,
                    'akhir_jam_masuk' => $akhir_jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'updated_at' => now()
                ]);
                if($simpan) {
                    return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
                }
            }            
        } catch (\Exception $e) {
            return redirect()->back()->with(['warning' => 'Data gagal disimpan!']);
        }
    }

    public function editjamkerja(Request $request)
    {
        $datas = JamKerja::where('kode_jam_kerja',$request->kode_jam_kerja)->first();
        return response()->json($datas);
    }

    public function destroyjamker($kode_jamker)
    {
        $delete = JamKerja::where('kode_jam_kerja',$kode_jamker)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }
}
