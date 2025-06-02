@extends('layouts.admin.tabler')
@section('title','Setting Jam Kerja')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
            Overview
        </div>
        <h2 class="page-title">
            Setting Jam Kerja
        </h2>
        </div>        
    </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-3">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>NIK</th>
                        <td>{{$karyawan->nik}}</td>
                    </tr>
                    <tr>
                        <th>Nama Karyawan</th>
                        <td>{{$karyawan->nama_lengkap}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                @if (Session::get('warning'))
                    <div class="alert alert-warning">
                        {{Session::get('warning')}}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="/konfigurasi/updatesetjamkerja" method="POST">
                    @csrf
                    <input type="hidden" name="nik" value="{{$karyawan->nik}}">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $jamker)
                                <tr>
                                    <td>{{$jamker->hari}}
                                        <input type="hidden" name="hari[]" value="{{$jamker->hari}}">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">- Pilih- </option>
                                            @foreach ($jamkerja as $item)
                                                <option {{$item->kode_jam_kerja == $jamker->kode_jam_kerja  ? 'selected' : ''}} value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary w-100" type="submit"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-progress-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /><path d="M9 12l2 2l4 -4" /></svg>Update</button>
                </form>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless card-table table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="text-align: center;">Master Jam Kerja</th>
                                    </tr>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Awal Masuk</th>
                                        <th>Jam Masuk</th>
                                        <th>Akhir Masuk</th>
                                        <th>Jam Pulang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jamkerja as $d)
                                        <tr>
                                            <td>{{$d->kode_jam_kerja}}</td>
                                            <td>{{$d->nama_jam_kerja}}</td>
                                            <td>{{$d->awal_jam_masuk}}</td>
                                            <td>{{$d->jam_masuk}}</td>
                                            <td>{{$d->akhir_jam_masuk}}</td>
                                            <td>{{$d->jam_pulang}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection