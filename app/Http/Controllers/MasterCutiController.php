<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterCuti;

class MasterCutiController extends Controller
{
    public function index(Request $request)
    {
        $cuti = MasterCuti::all();
        return view('administrator.master-cuti.index', compact('cuti'));
    }

    public function simpanmastercuti(Request $request)
    {        
        $kode_cuti = $request->kode_cuti;
        $nama_cuti = $request->nama_cuti;
        $jumlah_hari = $request->jumlah_hari;

        try {            
            if($request->hidkodecuti == ""){
                $data = [                
                    'kode_cuti' => $kode_cuti,
                    'nama_cuti' => $nama_cuti,
                    'jumlah_hari' => $jumlah_hari,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $simpan = MasterCuti::insert($data);
                if($simpan) {
                    return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
                }
            } else {
                $simpan = MasterCuti::where('kode_cuti',$request->hidkodecuti)->update([
                    'nama_cuti' => $nama_cuti,
                    'jumlah_hari' => $jumlah_hari,
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

    public function editmastercuti(Request $request)
    {
        $datas = MasterCuti::where('kode_cuti',$request->kode_cuti)->first();
        return response()->json($datas);
    }

    public function destroymastercuti($kode_cuti)
    {
        $delete = MasterCuti::where('kode_cuti',$kode_cuti)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }
}
