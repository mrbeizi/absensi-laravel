@extends('layouts.admin.tabler')
@section('title','Monitoring Presensi')

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
            Monitoring Presensi
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>
                                        </span>
                                        <input type="text" value="{{ date('Y-m-d') }}" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal Presensi" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            @role('administrator','user')
                            <div class="col-3">
                                <div class="form-group">
                                    <select name="kode_dept" id="kode_dept" class="form-select">
                                        <option value="">- Pilih Department -</option>
                                        @foreach($department as $dept)
                                        <option {{ Request('kode_dept') == $dept->kode_dept ? 'selected' : '' }} value="{{ $dept->kode_dept }}">{{ $dept->nama_dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                                        
                            <div class="col-3">
                                <div class="form-group">
                                    <select name="kode_cabang" id="kode_cabang" class="form-select">
                                        <option value="">- Pilih Kantor -</option>
                                        @foreach($cabang as $cab)
                                        <option {{ Request('kode_cabang') == $cab->kode_cabang ? 'selected' : '' }} value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole 
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NIK</th>
                                            <th>Nama Karyawan</th>
                                            <th>Dept</th>
                                            <th>Jadwal</th>
                                            <th>Status</th>
                                            <th>Jam Masuk</th>
                                            <th>Foto</th>
                                            <th>Jam Pulang</th>
                                            <th>Foto</th>
                                            <th>Keterangan</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="loadpresensi"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-peta" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Lokasi Presensi User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadpeta"></div>        
    </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-koreksipresensi" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Koreksi Presensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadkoreksi"></div>        
    </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        $('#tanggal').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        function loadpresensi() {
            var tanggal = $('#tanggal').val();
            var kode_dept = $('#kode_dept').val();
            var kode_cabang = $('#kode_cabang').val();
            $.ajax({
                type: "POST",
                url: "{{route('get-presensi')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal,
                    kode_dept: kode_dept,
                    kode_cabang: kode_cabang
                },
                cache: false,
                success:function(respond){
                    $('#loadpresensi').html(respond);
                }
            });
        }

        $('#tanggal').change(function() {
            loadpresensi();
        });

        $('#kode_dept').change(function() {
            loadpresensi();
        });

        $('#kode_cabang').change(function() {
            loadpresensi();
        });

        loadpresensi();
    });
</script>
    
@endpush