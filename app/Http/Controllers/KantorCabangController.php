<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;

class KantorCabangController extends Controller
{
    public function index(Request $request)
    {
        $query = Cabang::query();
        if(!empty($request->kd_cabang)){
            $kantorcabang = $query->where('kode_cabang',$request->kd_cabang);
        }
        $kantorcabang = $query->get();

        $datakacab = Cabang::all();
        return view('administrator.kantor-cabang.index', compact('kantorcabang','datakacab'));
    }
    public function simpan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        try {
            $data = [
                'kode_cabang' => $kode_cabang,
                'nama_cabang' => $nama_cabang,
                'lokasi_kantor' => $lokasi_kantor,
                'radius' => $radius,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $simpan = Cabang::insert($data);
            if($simpan) {                
                return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
            }
        } catch (\Exception $e) {
            if($e->getCode() == 23000) {
                $message = "Kode cabang ".$kode_cabang." sudah ada";
            } else {
                $message = "Ada kesalahan inputan.";
            }
            return redirect()->back()->with(['warning' => 'Data gagal disimpan. '. $message]);
        }
    }

    public function edit(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kantorcabang = Cabang::where('kode_cabang',$kode_cabang)->first();
        return view('administrator.kantor-cabang.edit', compact('kantorcabang'));
    }

    public function update($kode_cabang, Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        try {
            $data = [
                'kode_cabang' => $kode_cabang,
                'nama_cabang' => $nama_cabang,
                'lokasi_kantor' => $lokasi_kantor,
                'radius' => $radius
            ];
            $update = Cabang::where('kode_cabang',$kode_cabang)->update($data);
            if($update) {
                return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
            }
        } catch (\Exception $e) {
            if($e->getCode() == 23000) {
                $message = "Kode cabang ".$kode_cabang." sudah ada";
            }
            return redirect()->back()->with(['warning' => 'Data gagal diupdate. '. $message]);
        }
    }

    public function destroy($kode_cabang)
    {
        $delete = Cabang::where('kode_cabang',$kode_cabang)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }
}
