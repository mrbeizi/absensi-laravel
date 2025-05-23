<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function prosesLogin(Request $request)
    {
        if(Auth::guard('karyawan')->attempt(['nik' => $request->nik,'password' => $request->password])){
            return Redirect::route('dashboard');
        }else{
            return Redirect::route('login')->with(['error' => 'NIK atau Password salah.']);
        }

    }

    public function prosesLogout()
    {
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }

    public function prosesLogoutAdmin()
    {
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }

    public function prosesLoginAdmin(Request $request)
    {
        if(Auth::guard('user')->attempt(['email' => $request->email,'password' => $request->password])){
            return Redirect::route('dashboardadmin');
        }else{
            return Redirect::route('loginadmin')->with(['warning' => 'Email atau Password salah.']);
        }

    }
}
