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
            ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
            ->where('nik',$nik)
            ->orderBy('tgl_presensi','DESC')
            ->get();
        $monthName = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $yearNow = date('Y');

        # Recap data absensi
        $recapData = DB::table('presensis')->selectRaw('COUNT(nik) as sum_presence, SUM(IF(jam_in > jam_masuk,1,0)) as sum_late')
            ->leftJoin('jam_kerjas','jam_kerjas.kode_jam_kerja','=','presensis.kode_jam_kerja')
            ->where('nik',$nik)
            ->whereRaw('MONTH(tgl_presensi)="'.$thisMonth.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$thisYear.'"')
            ->first();

        # Leaderboard
        $leaderBoard = DB::table('presensis')->leftJoin('karyawans','karyawans.nik','=','presensis.nik')->where('presensis.tgl_presensi',$today)->get();

        # rekapIzin\
        $recapIzin = DB::table('pengajuan_izins')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik',$nik)
            ->whereRaw('MONTH(tgl_izin)="'.$thisMonth.'"')
            ->whereRaw('YEAR(tgl_izin)="'.$thisYear.'"')
            ->where('status_approved',1)
            ->first();

        return view('dashboard.index', compact('todayPresence','historyPerMonth','monthName','yearNow','recapData','leaderBoard','recapIzin'));
    }

    public function dashboardadmin(Request $request)
    {
        $today = date("Y-m-d");
        $recapData = DB::table('presensis')->selectRaw('COUNT(nik) as sum_presence, SUM(IF(jam_in > "07:00",1,0)) as sum_late')
            ->where('tgl_presensi',$today)
            ->first();
        
        $recapIzin = DB::table('pengajuan_izins')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tgl_izin',$today)
            ->where('status_approved',1)
            ->first();
        return view('dashboard.dashboardadmin', compact('recapData','recapIzin'));
    }
}
