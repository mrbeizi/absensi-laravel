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
            return Redirect::route('login')->with(['error' => 'NIK / Password salah.']);
        }

    }

    public function prosesLogout()
    {
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }
}
