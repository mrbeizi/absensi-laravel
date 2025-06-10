<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class PerizinanController extends Controller
{
    public function indexizinabsen()
    {
        return view('perizinan.izinabsen');
    }

    public function storeizinabsen(Request $request)
    {
        $m = date("m", strtotime($request->tgl_izin_dari));
        $y = date("Y", strtotime($request->tgl_izin_dari));
        $digitY = substr($y, 2, 2);

        $latest = DB::table('pengajuan_izins')
            ->whereRaw('MONTH(tgl_izin_dari)="'.$m.'"')
            ->whereRaw('YEAR(tgl_izin_dari)="'.$y.'"')
            ->orderBy('kode_izin','DESC')
            ->first();

        $latestIzinCode = $latest != null ? $latest->kode_izin : "";
        $format = "IZ".$m.$digitY;
        $izinCode = izinCodeGen($latestIzinCode,$format,4);

        $post = DB::table('pengajuan_izins')->insert([
            'kode_izin' => $izinCode,
            'nik' => Auth::guard('karyawan')->user()->nik,
            'tgl_izin_dari' => $request->tgl_izin_dari,
            'tgl_izin_sampai' => $request->tgl_izin_sampai,
            'status' => 'i',
            'keterangan' => $request->keterangan,
            'status_approved' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if($post){
            return redirect()->route('presensi-izin')->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect()->route('presensi-izin')->with(['error' => 'Data gagal disimpan!']);
        }
    }

    public function indexizinsakit()
    {
        return view('perizinan.izinsakit');
    }

    public function storeizinsakit(Request $request)
    {
        $m = date("m", strtotime($request->tgl_izin_dari));
        $y = date("Y", strtotime($request->tgl_izin_dari));
        $digitY = substr($y, 2, 2);

        $latest = DB::table('pengajuan_izins')
            ->whereRaw('MONTH(tgl_izin_dari)="'.$m.'"')
            ->whereRaw('YEAR(tgl_izin_dari)="'.$y.'"')
            ->orderBy('kode_izin','DESC')
            ->first();

        $latestIzinCode = $latest != null ? $latest->kode_izin : "";
        $format = "IZ".$m.$digitY;
        $izinCode = izinCodeGen($latestIzinCode,$format,4);

        if ($request->hasFile('sid')) {
            $sid = $izinCode . "." . $request->file('sid')->getClientOriginalExtension();
        } else {
            $sid = null;
        }
        
        $post = DB::table('pengajuan_izins')->insert([
            'kode_izin' => $izinCode,
            'nik' => Auth::guard('karyawan')->user()->nik,
            'tgl_izin_dari' => $request->tgl_izin_dari,
            'tgl_izin_sampai' => $request->tgl_izin_sampai,
            'status' => 's',
            'keterangan' => $request->keterangan,
            'docs_sid' => $sid,
            'status_approved' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if($post){
            if ($request->hasFile('sid')) {
                $sid = $izinCode . "." . $request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid";
                $request->file('sid')->storeAs($folderPath, $sid);
            }
            return redirect()->route('presensi-izin')->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect()->route('presensi-izin')->with(['error' => 'Data gagal disimpan!']);
        }
    }
}
