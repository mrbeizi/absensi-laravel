<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;
use DB;
use Auth;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();
        $query->select('karyawans.*','nama_dept');
        $query->join('departments','karyawans.kode_dept','=','departments.kode_dept');
        $query->orderBy('nama_lengkap');

        if(!empty($request->nama_lengkap)){
            $query->where('nama_lengkap','like','%'.$request->nama_lengkap.'%');
        }

        if(!empty($request->kode_dept)){
            $query->where('karyawans.kode_dept', $request->kode_dept);
        }

        $karyawan = $query->paginate(10);
        
        $department = DB::table('departments')->orderBy('nama_dept','ASC')->get();
        return view('administrator.karyawan.index', compact('karyawan','department'));
    }

    public function simpan(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_telp = $request->no_telp;
        $kode_dept = $request->kode_dept;

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
            }
            return redirect()->back()->with(['warning' => 'Data gagal disimpan. '. $message]);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $department = DB::table('departments')->orderBy('nama_dept','ASC')->get();

        $karyawan = Karyawan::where('nik',$nik)->first();
        return view('administrator.karyawan.edit', compact('department','karyawan'));
    }

    public function update($nik, Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_telp = $request->no_telp;
        $kode_dept = $request->kode_dept;

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

}
