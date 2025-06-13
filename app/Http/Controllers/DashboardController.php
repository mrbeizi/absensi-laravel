<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date("Y-m-d");
        $thisMonth = date("m") * 1;
        $thisYear = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;
        $todayPresence = DB::table('presensis')->where([['tgl_presensi',$today],['nik',$nik]])->first();
        $historyPerMonth = DB::table('presensis')
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->leftJoin('pengajuan_izins','pengajuan_izins.kode_izin','=','presensis.kode_izin')
            ->leftJoin('master_cutis','master_cutis.kode_cuti','=','pengajuan_izins.kode_cuti')
            ->select('presensis.*','jam_kerjas.*','pengajuan_izins.keterangan','docs_sid','nama_cuti')
            ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
            ->where('presensis.nik',$nik)
            ->orderBy('tgl_presensi','DESC')
            ->get();
        $monthName = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $yearNow = date('Y');

        # Recap data absensi
        $recapData = DB::table('presensis')->selectRaw('SUM(IF(jam_in > jam_masuk,1,0)) as sum_late, SUM(IF(status="h",1,0)) as jmlhadir, SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit, SUM(IF(status="c",1,0)) as jmlcuti')
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->where('nik',$nik)
            ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
            ->first();

        # Leaderboard
        $leaderBoard = DB::table('presensis')->leftJoin('karyawans','karyawans.nik','=','presensis.nik')->where('presensis.tgl_presensi',$today)->get();

        return view('dashboard.index', compact('todayPresence','historyPerMonth','monthName','yearNow','recapData','leaderBoard'));
    }

    public function dashboardadmin(Request $request)
    {
        $today = date("Y-m-d");
        # Recap data presensi
        $recapData = DB::table('presensis')->selectRaw('SUM(IF(jam_in > jam_masuk,1,0)) as sum_late, SUM(IF(status="h",1,0)) as jmlhadir, SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit, SUM(IF(status="c",1,0)) as jmlcuti')
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->where('tgl_presensi',$today)
            ->first();
        return view('dashboard.dashboardadmin', compact('recapData'));
    }
}
