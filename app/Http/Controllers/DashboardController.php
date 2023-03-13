<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $todayPresence = DB::table('presensis')->where([['tgl_presensi',date('Y-m-d')],['nik',Auth::guard('karyawan')->user()->nik]])->first();
        $historyPerMonth = DB::table('presensis')
            ->whereRaw('MONTH(tgl_presensi)="'.date('m').'"')
            ->whereRaw('YEAR(tgl_presensi)="'.date('Y').'"')
            ->where('nik',Auth::guard('karyawan')->user()->nik)
            ->orderBy('tgl_presensi','DESC')
            ->get();
        $monthName = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $yearNow = date('Y');

        # Recap data absensi
        $recapData = DB::table('presensis')->selectRaw('COUNT(nik) as sum_presence, SUM(IF(jam_in > "07:00",1,0)) as sum_late')
            ->where('nik',Auth::guard('karyawan')->user()->nik)
            ->whereRaw('MONTH(tgl_presensi)="'.date('m').'"')
            ->whereRaw('YEAR(tgl_presensi)="'.date('Y').'"')
            ->first();

        # Leaderboard
        $leaderBoard = DB::table('presensis')->leftJoin('karyawans','karyawans.nik','=','presensis.nik')->where('presensis.tgl_presensi',date('Y-m-d'))->get();

        return view('dashboard.index', compact('todayPresence','historyPerMonth','monthName','yearNow','recapData','leaderBoard'));
    }
}
