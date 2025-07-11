<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;
use App\Models\Cabang;
use App\Models\User;
use DB;
use Auth;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        # menerapkan role
        $getKodeDept = Auth::guard('user')->user()->kode_dept;
        $getKodeCabang = Auth::guard('user')->user()->kode_cabang;
        $getUser = User::find(Auth::guard('user')->user()->id);

        $query = Karyawan::query();
        $query->select('karyawans.*','nama_dept','nama_cabang');
        $query->join('departments','karyawans.kode_dept','=','departments.kode_dept');
        $query->join('cabangs','karyawans.kode_cabang','=','cabangs.kode_cabang');
        $query->orderBy('nama_lengkap');

        if(!empty($request->nama_lengkap)){
            $query->where('nama_lengkap','like','%'.$request->nama_lengkap.'%');
        }

        if(!empty($request->kode_dept)){
            $query->where('karyawans.kode_dept', $request->kode_dept);
        }

        if(!empty($request->kd_cabang)){
            $query->where('cabangs.kode_cabang', $request->kd_cabang);
        }

        if($getUser->hasRole('Admin Departemen')) {
            $query->where('karyawans.kode_dept',$getKodeDept);
            $query->where('karyawans.kode_cabang',$getKodeCabang);
        }

        $karyawan = $query->paginate(10);
        
        $department = DB::table('departments')->orderBy('nama_dept','ASC')->get();
        $datacabang = Cabang::orderBy('nama_cabang')->get();
        return view('administrator.karyawan.index', compact('karyawan','department','datacabang'));
    }

    public function simpan(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_telp = $request->no_telp;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;

        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_telp' => $no_telp,
                'kode_dept' => $kode_dept,
                'kode_cabang' => $kode_cabang,
                'password' => Hash::make($nik), # create default password
                'foto' => $foto,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $simpan = Karyawan::insert($data);
            if($simpan) {
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
            }
        } catch (\Exception $e) {
            if($e->getCode() == 23000) {
                $message = "NIK ".$nik." sudah ada";
            } else {
                $message = "Ada kesalahan inputan.";
            }
            return redirect()->back()->with(['warning' => 'Data gagal disimpan. '. $message]);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $department = DB::table('departments')->orderBy('nama_dept','ASC')->get();
        $datacabang = Cabang::orderBy('nama_cabang','ASC')->get();

        $karyawan = Karyawan::where('nik',$nik)->first();
        return view('administrator.karyawan.edit', compact('department','datacabang','karyawan'));
    }

    public function update($nik, Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_telp = $request->no_telp;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;

        $old_foto = $request->old_foto;
        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_telp' => $no_telp,
                'kode_dept' => $kode_dept,
                'kode_cabang' => $kode_cabang,
                'foto' => $foto,
            ];
            $update = Karyawan::where('nik',$nik)->update($data);
            if($update) {
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/".$old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function destroy($nik)
    {
        $delete = Karyawan::where('nik',$nik)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }

    public function resetpassword($nik)
    {
        $reset = Karyawan::where('nik',$nik)->update([
            'password' => Hash::make($nik)
        ]);
        if($reset){
            return redirect()->back()->with(['success' => 'Password berhasil direset']);
        } else {
            return redirect()->back()->with(['warning' => 'Password gagal direset']);
        }
    }

    public function switchlocation($nik)
    {
        try {
            $karyawan = Karyawan::where('nik',$nik)->first();
            $status = $karyawan->status_loc;
            if($status == '1'){
                Karyawan::where('nik',$nik)->update([
                    'status_loc' => '0'
                ]);
            } else {
                Karyawan::where('nik',$nik)->update([
                    'status_loc' => '1'
                ]);
            }
            return redirect()->back()->with(['success' => 'Status lokasi berhasil diupdate']);
        } catch (\Exception $e) {
           return redirect()->back()->with(['warning' => 'Status lokasi gagal diupdate']);
        }
    }

    public function switchjamker($nik)
    {
        try {
            $karyawan = Karyawan::where('nik',$nik)->first();
            $status = $karyawan->status_jam_kerja;
            if($status == '1'){
                Karyawan::where('nik',$nik)->update([
                    'status_jam_kerja' => '0'
                ]);
            } else {
                Karyawan::where('nik',$nik)->update([
                    'status_jam_kerja' => '1'
                ]);
            }
            return redirect()->back()->with(['success' => 'Status jam kerja berhasil diubah']);
        } catch (\Exception $e) {
           return redirect()->back()->with(['warning' => 'Status jam kerja gagal diubah']);
        }
    }

}
