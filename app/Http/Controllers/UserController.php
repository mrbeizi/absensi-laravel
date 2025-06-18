<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Cabang;
use DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $nama_user = $request->nama_user;
        $query = User::query();
        $query->leftJoin('departments','users.kode_dept','=','departments.kode_dept');
        $query->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id');
        $query->leftJoin('roles','model_has_roles.role_id','=','roles.id');
        $query->leftJoin('cabangs','users.kode_cabang','=','cabangs.kode_cabang');
        $query->select('users.id','users.name','users.email','nama_dept','roles.name AS role','nama_cabang');
        if(!empty($nama_user)){
            $query->where('users.name','like','%'.$nama_user.'%');
        }
        $datas = $query->get();
        $department = Department::orderBy('nama_dept')->get();
        $roles = DB::table('roles')->get();
        $cabang = Cabang::orderBy('nama_cabang')->get();
        return view('administrator.data-user.index', compact('datas','department','roles','cabang'));
    }

    public function simpan(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $kode_dept = $request->kode_dept;
        $role = $request->role;
        $kode_cabang = $request->kode_cabang;

        DB::beginTransaction();
        try {
            $data = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('123456'),
                'kode_dept' => $kode_dept,
                'kode_cabang' => $kode_cabang,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $data->assignRole($role);
            DB::commit();
            return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
        } catch (\Exception $e) { 
            // dd($e);
            DB::rollBack();           
            return redirect()->back()->with(['warning' => 'Terjadi kesalahan. Data gagal disimpan.']);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')->where('users.id',$id)->first();
        $department = Department::orderBy('nama_dept')->get();
        $roles = DB::table('roles')->get();
        $cabang = Cabang::orderBy('nama_cabang')->get();
        return view('administrator.data-user.edit', compact('user','department','roles','cabang'));
    }

    public function update($id, Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;

        DB::beginTransaction();
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'kode_dept' => $kode_dept,
                'kode_cabang' => $kode_cabang
            ];
            $update = User::where('id',$id)->update($data);
            DB::table('model_has_roles')->where('model_id',$id)->update(['role_id' => $request->role]);
            DB::commit();
            if($update) {
                return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
            }
        } catch (\Exception $e) {
            DB::rollBack();   
            return redirect()->back()->with(['warning' => 'Terjadi kesalahan. Data gagal diupdate']);
        }
    }

    public function destroy($id)
    {
        $delete = User::where('id',$id)->delete();
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'User berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'User gagal dihapus']);
        }
    }
}
