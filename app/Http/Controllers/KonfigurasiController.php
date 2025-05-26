<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
