<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JamKerja;
use App\Models\Karyawan;
use App\Models\Cabang;
use App\Models\Department;
use App\Models\KonfigurasiJamKerja;
use App\Models\KonfigurasiJamKerjaDepartment;
use App\Models\KonfigurasiJamKerjaDepartmentDetail;
use App\Models\HariLibur;
use DB;

class KonfigurasiController extends Controller
{
    public function lokasikantor(Request $request)
    {
        $office_loc = DB::table('konfigurasi_lokasis')->where('id',1)->first();
        return view('administrator.konfigurasi.lokasikantor', compact('office_loc'));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('konfigurasi_lokasis')->where('id',1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if($update){
            return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function jamkerja(Request $request)
    {
        $jamkerja = JamKerja::all();
        return view('administrator.konfigurasi.jamkerja', compact('jamkerja'));
    }

    public function simpanjamkerja(Request $request)
    {        
        $kode_jamker = $request->kode_jam_kerja;
        $nama_jamker = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;
        $lintas_hari = $request->lintas_hari;

        try {            
            if($request->hidkodejamker == ""){
                $data = [                
                    'kode_jam_kerja' => $kode_jamker,
                    'nama_jam_kerja' => $nama_jamker,
                    'awal_jam_masuk' => $awal_jam_masuk,
                    'jam_masuk' => $jam_masuk,
                    'akhir_jam_masuk' => $akhir_jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'lintas_hari' => $lintas_hari,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $simpan = JamKerja::insert($data);
                if($simpan) {
                    return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
                }
            } else {
                $simpan = JamKerja::where('kode_jam_kerja',$request->hidkodejamker)->update([
                    'nama_jam_kerja' => $nama_jamker,
                    'awal_jam_masuk' => $awal_jam_masuk,
                    'jam_masuk' => $jam_masuk,
                    'akhir_jam_masuk' => $akhir_jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'lintas_hari' => $lintas_hari,
                    'updated_at' => now()
                ]);
                if($simpan) {
                    return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
                }
            }            
        } catch (\Exception $e) {
            return redirect()->back()->with(['warning' => 'Data gagal disimpan!']);
        }
    }

    public function editjamkerja(Request $request)
    {
        $datas = JamKerja::where('kode_jam_kerja',$request->kode_jam_kerja)->first();
        return response()->json($datas);
    }

    public function destroyjamker($kode_jamker)
    {
        $delete = JamKerja::where('kode_jam_kerja',$kode_jamker)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }

    public function setjamkerja($nik)
    {
        $monthName = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $karyawan = Karyawan::where('nik',$nik)->first();
        $jamkerja = JamKerja::orderBy('nama_jam_kerja')->get();
        $cekexist = KonfigurasiJamKerja::where('nik',$nik)->count();
        if($cekexist > 0){
            $data = KonfigurasiJamKerja::where('nik',$nik)->get();
            return view('administrator.konfigurasi.editsetjamkerja', compact('karyawan','jamkerja','data','monthName'));
        } else {
            return view('administrator.konfigurasi.setjamkerja', compact('karyawan','jamkerja','monthName'));
        }
    }

    public function storesetjamkerja(Request $request)
    {
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jamker = $request->kode_jam_kerja;

        for($i = 0; $i < count($hari); $i++){
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jamker[$i],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        try {
            $simpan = KonfigurasiJamKerja::insert($data);
            if($simpan){
                return redirect('/karyawan')->with(['success' => 'Data berhasil disimpan']);
            }
        } catch (\Exception $e) {
           return redirect('/karyawan')->with(['warning' => 'Data gagal disimpan']);
        }
        
    }

    public function simpanpertanggal(Request $request)
    {
        $nik = $request->nik;
        $tanggal = $request->tanggal;
        $kode_jamker = $request->kd_jamker;

        $data = [
            'nik' => $nik,
            'tanggal' => $tanggal,
            'kode_jam_kerja' => $kode_jamker,
            'created_at' => now(),
            'updated_at' => now()
        ];

        try {
            DB::table('konfigurasi_jam_kerja_pertanggals')->insert($data);
            return 1;
        } catch (\Exception $e) {
           return 0;
        }
    }

    public function showpertanggal($nik, $bulan, $tahun)
    {
        $datas = DB::table('konfigurasi_jam_kerja_pertanggals')
            ->join('jam_kerjas','jam_kerjas.kode_jam_kerja','=','konfigurasi_jam_kerja_pertanggals.kode_jam_kerja')
            ->select('konfigurasi_jam_kerja_pertanggals.*','nama_jam_kerja')
            ->where('nik',$nik)
            ->whereRaw('MONTH(tanggal)="'.$bulan.'"')
            ->whereRaw('YEAR(tanggal)="'.$tahun.'"')
            ->get();
        return view('administrator.konfigurasi.showjamkerjapertanggal', compact('datas','nik','bulan','tahun'));
    }

    public function hapuspertanggal(Request $request)
    {
        $nik = $request->nik;
        $tanggal = $request->tanggal;

        try {
            DB::table('konfigurasi_jam_kerja_pertanggals')->where('nik',$nik)->where('tanggal',$tanggal)->delete();
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function updatesetjamkerja(Request $request)
    {
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jamker = $request->kode_jam_kerja;

        for($i = 0; $i < count($hari); $i++){
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jamker[$i],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::beginTransaction();
        try {
            KonfigurasiJamKerja::where('nik',$nik)->delete();
            $simpan = KonfigurasiJamKerja::insert($data);
            DB::commit();
            if($simpan){
                return redirect('karyawan')->with(['success' => 'Data berhasil diupdate']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
           return redirect('karyawan')->with(['warning' => 'Data gagal diupdate']);
        }
        
    }

    public function jamkerjadept(Request $request)
    {
        $datacabang = Cabang::all();
        $department = Department::all();
        $jamKerjaDept = KonfigurasiJamKerjaDepartment::join('departments','departments.kode_dept','=','konfigurasi_jam_kerja_departments.kode_dept')
            ->join('cabangs','cabangs.kode_cabang','=','konfigurasi_jam_kerja_departments.kode_cabang')
            ->get();
        $jamkerja = JamKerja::all();
        $detJamKerjaDept = KonfigurasiJamKerjaDepartment::all();
        return view('administrator.konfigurasi.jamkerjadept', compact('datacabang','department','jamKerjaDept','jamkerja','detJamKerjaDept'));
    }

    public function simpanjamkerjadepartment(Request $request)
    {       
        $kode_cabang = $request->kode_cabang;
        $kode_dept = $request->kode_dept;
        $hari = $request->hari;
        $kode_jamker = $request->kode_jam_kerja;

        # Generate kode jam kerja department
        $kode = "J" . $kode_cabang . $kode_dept;

        DB::beginTransaction();
        try {            
            if($request->hidkodejamker == ""){
                $data = [                
                    'kode_jam_kerja_dept' => $kode,
                    'kode_cabang' => $kode_cabang,
                    'kode_dept' => $kode_dept,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                KonfigurasiJamKerjaDepartment::insert($data);

                for($i = 0; $i < count($hari); $i++){
                    $dt[] = [
                        'kode_jam_kerja_dept' => $kode,
                        'hari' => $hari[$i],
                        'kode_jam_kerja' => $kode_jamker[$i],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                } 
                KonfigurasiJamKerjaDepartmentDetail::insert($dt);
                DB::commit();
            } else {
                for($i = 0; $i < count($hari); $i++){
                    $dt[] = [
                        'kode_jam_kerja_dept' => $request->hidkodejamker,
                        'hari' => $hari[$i],
                        'kode_jam_kerja' => $kode_jamker[$i],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                } 
                KonfigurasiJamKerjaDepartmentDetail::where('kode_jam_kerja_dept',$request->hidkodejamker)->delete();
                KonfigurasiJamKerjaDepartmentDetail::insert($dt);
                DB::commit();
            }
            return redirect()->back()->with(['success' => 'Data berhasil disimpan!']);       
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['warning' => 'Data gagal disimpan!']);
        }        
    }

    public function editjamkerjadepartment(Request $request)
    {
        $datas = KonfigurasiJamKerjaDepartment::where('kode_jam_kerja_dept',$request->kode_jam_kerja_dept)->first();
        $detailjamkerdept = KonfigurasiJamKerjaDepartmentDetail::join('jam_kerjas', 'konfigurasi_jam_kerja_department_details.kode_jam_kerja', '=', 'jam_kerjas.kode_jam_kerja')
            ->where('konfigurasi_jam_kerja_department_details.kode_jam_kerja_dept', $request->kode_jam_kerja_dept)
            ->select('konfigurasi_jam_kerja_department_details.*', 'jam_kerjas.nama_jam_kerja')
            ->get();
        $jamkerja = JamKerja::all();
        return response()->json(['datas' => $datas, 'detailjamkerdept' => $detailjamkerdept,'data_jam_kerja' => $jamkerja]);
    }

    public function destroyjamkerdepartment($kode_jamker)
    {
        $delete = KonfigurasiJamKerjaDepartment::where('kode_jam_kerja_dept',$kode_jamker)->delete();
        KonfigurasiJamKerjaDepartmentDetail::where('kode_jam_kerja_dept',$kode_jamker)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }

    public function showjadwaljamkerdepartment(Request $request)
    {
        $datas = KonfigurasiJamKerjaDepartment::join('cabangs','cabangs.kode_cabang','=','konfigurasi_jam_kerja_departments.kode_cabang')
            ->join('departments','departments.kode_dept','=','konfigurasi_jam_kerja_departments.kode_dept')
            ->select('cabangs.nama_cabang','departments.nama_dept','konfigurasi_jam_kerja_departments.kode_jam_kerja_dept')
            ->where('kode_jam_kerja_dept',$request->kode_jam_kerja_dept)
            ->first();
        $detailjamkerdept = KonfigurasiJamKerjaDepartmentDetail::join('jam_kerjas', 'konfigurasi_jam_kerja_department_details.kode_jam_kerja', '=', 'jam_kerjas.kode_jam_kerja')
            ->where('konfigurasi_jam_kerja_department_details.kode_jam_kerja_dept', $request->kode_jam_kerja_dept)
            ->select('konfigurasi_jam_kerja_department_details.*', 'jam_kerjas.nama_jam_kerja')
            ->get();

        return view('administrator.konfigurasi.showjadwaljamkerjadept', compact('datas','detailjamkerdept'));
    }

    public function harilibur(Request $request)
    {
        $harilibur = HariLibur::leftJoin('cabangs','cabangs.kode_cabang','=','hari_liburs.kode_cabang')->get();
        $datacabang = Cabang::orderBy('nama_cabang')->get();
        return view('administrator.hari-libur.index', compact('harilibur','datacabang'));
    }

    public function simpanharilibur(Request $request)
    {
        $d = date("d", strtotime($request->tgl_libur));
        $m = date("m", strtotime($request->tgl_libur));
        $y = date("Y", strtotime($request->tgl_libur));
        $digitY = substr($y, 2, 2);
        $format = "LB".$digitY.$m.$d;

        try {
            if($request->hidkodelibur == ""){
                $data = [
                    'kode_libur' => $format,
                    'tgl_libur' => $request->tgl_libur,
                    'kode_cabang' => $request->kode_cabang,
                    'keterangan' => $request->keterangan  
                ];

                $simpan = HariLibur::insert($data);
                if($simpan){
                    return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
                }
            } else {
                $simpan = HariLibur::where('kode_libur',$request->hidkodelibur)->update([
                    'tgl_libur' => $request->tgl_libur,
                    'kode_cabang' => $request->kode_cabang,
                    'keterangan' => $request->keterangan 
                ]);
                if($simpan) {
                    return redirect()->back()->with(['success' => 'Data berhasil diupdate']);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['warning' => 'Data gagal disimpan']);
        }
    }

    public function editharilibur(Request $request)
    {
        $datas = HariLibur::where('kode_libur',$request->kode_libur)->first();
        return response()->json($datas);
    }

    public function hapusharilibur($kode_libur)
    {
        $delete = HariLibur::where('kode_libur',$kode_libur)->delete();
        if($delete){
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data gagal dihapus']);
        }
    }

    public function setharilibur($kode_libur)
    {
        $harilibur = HariLibur::where('kode_libur',$kode_libur)->first();
        return view('administrator.hari-libur.setkaryawanlibur', compact('harilibur'));
    }

    public function setlistkaryawanlibur($kode_libur)
    {
        return view('administrator.hari-libur.setlistkaryawanlibur', compact('kode_libur'));
    }

    public function getlistkaryawanlibur($kode_libur)
    {
        $harilibur = HariLibur::where('kode_libur',$kode_libur)->first();
        $karyawan = Karyawan::select('karyawans.*','data.nik AS datanik')
            ->leftJoin(
                DB::raw("(
                SELECT nik from hari_libur_details
                WHERE kode_libur = '$kode_libur'
                ) data"),
                 function($join) {
                    $join->on('karyawans.nik','=','data.nik');
                 }
            )
            ->where('kode_cabang',$harilibur->kode_cabang)
            ->orderBy('nama_lengkap')
            ->get();
        return view('administrator.hari-libur.getlistkaryawanlibur', compact('karyawan','kode_libur'));
    }

    public function simpankaryawanlibur(Request $request)
    {
        $kode_libur = $request->kode_libur;
        $nik = $request->nik;

        try {
            $checking = DB::table('hari_libur_details')->where('kode_libur',$kode_libur)->where('nik',$nik)->count();
            if($checking > 0){
                return "exist";
            }
            DB::table('hari_libur_details')->insert([
                'kode_libur' => $kode_libur,
                'nik' => $nik,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function hapuskaryawanlibur(Request $request)
    {
        $kode_libur = $request->kode_libur;
        $nik = $request->nik;
        try {
            DB::table('hari_libur_details')->where('kode_libur',$kode_libur)->where('nik',$nik)->delete();
            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getkaryawanlibur($kode_libur)
    {
        $karyawan = DB::table('hari_libur_details')
            ->join('karyawans','karyawans.nik','=','hari_libur_details.nik')
            ->where('kode_libur',$kode_libur)
            ->get();
        return view('administrator.hari-libur.datakaryawanlibur', compact('karyawan','kode_libur'));
    }
}
