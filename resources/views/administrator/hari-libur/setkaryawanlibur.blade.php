@extends('layouts.admin.tabler')
@section('title','Konfigurasi')

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
            Konfigurasi Hari Libur Karyawan
        </h2>
        </div>        
    </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
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
            <div class="col-4">
                <div class="card">
                    <div class="card-body">                        
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td>Kode Libur</td>
                                <td>{{$harilibur->kode_libur}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Libur</td>
                                <td>{{date('d-m-Y', strtotime($harilibur->tgl_libur))}}</td>
                            </tr>
                            <tr>
                                <td>Kantor</td>
                                <td>{{$harilibur->kode_cabang}}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>{{$harilibur->keterangan}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <a href="javascript:void()" class="btn btn-primary" id="btnTambahKaryawan">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    Tambah Data 
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama Karyawan</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loadlistkaryawan"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-inputkaryawan" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Tambah Data Karyawan Libur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadaddform"></div>        
    </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        function loadlistkaryawan() {
            var kode_libur = "{{$harilibur->kode_libur}}";
            $('#loadlistkaryawan').load('/hari-libur/setharilibur/'+ kode_libur +'/getkaryawanlibur');
        }
        loadlistkaryawan();

        $('#btnTambahKaryawan').click(function() {
            var kode_libur = "{{$harilibur->kode_libur}}";
            $('#modal-inputkaryawan').modal('show');
            $('#loadaddform').load('/hari-libur/setharilibur/'+ kode_libur +'/listkaryawan');
        });
    });
</script>
@endpush