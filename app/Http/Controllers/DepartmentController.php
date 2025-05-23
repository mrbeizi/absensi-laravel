<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use DB;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $query = Department::query();
        $query->select('*');
        if(!empty($nama_dept)){
            $query->where('nama_dept','like','%'.$nama_dept.'%');
        }
        $department = $query->get();
        // $department = Department::orderBy('kode_dept')->get();
        return view('administrator.department.index', compact('department'));
    }

    public function simpan(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;

        try {
            $data = [
                'kode_dept' => $kode_dept,
                'nama_dept' => $nama_dept,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $simpan = Department::insert($data);
            if($simpan) {                
                return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with(['warning' => 'Data gagal disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $department = Department::where('kode_dept',$kode_dept)->first();
        return view('administrator.department.edit', compact('department'));
    }

    public function update($kode_dept, Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;

        try {
            $data = [
                'kode_dept' => $kode_dept,
                'nama_dept' => $nama_dept
            ];
            $update = Department::where('kode_dept',$kode_dept)->update($data);
            if($update) {
                return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function destroy($kode_dept)
    {
        $delete = Department::where('kode_dept',$kode_dept)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }
}
