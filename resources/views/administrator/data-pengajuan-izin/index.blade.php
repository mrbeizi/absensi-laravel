@extends('layouts.admin.tabler')
@section('title','Data Pengajuan Izin')

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
            Data Pengajuan Izin
        </h2>
        </div>        
    </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <form action="{{route('data-izinsakit')}}" method="GET" autocomplete="off">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                </span>
                                <input type="text" value="{{Request('dari')}}" name="dari" id="dari" class="form-control" placeholder="Dari">
                            </div>                           
                        </div>
                        <div class="col-6">
                             <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                </span>
                                <input type="text" value="{{Request('sampai')}}" name="sampai" id="sampai" class="form-control" placeholder="Sampai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-scan"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 12l14 0" /></svg>
                                </span>
                                <input type="text" value="{{Request('nik')}}" name="nik" id="nik" class="form-control" placeholder="NIK">
                            </div>  
                        </div>
                        <div class="col-2">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                </span>
                                <input type="text" value="{{Request('nama_lengkap')}}" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Nama Karyawan">
                            </div>  
                        </div>
                        @role('administrator','user')
                        <div class="col-2">
                            <div class="form-group">
                                <select name="kode_dept" id="kode_dept" class="form-select">
                                    <option value="">- Pilih Department -</option>
                                    @foreach($department as $dept)
                                    <option {{ Request('kode_dept') == $dept->kode_dept ? 'selected' : '' }} value="{{ $dept->kode_dept }}">{{ $dept->nama_dept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                                        
                        <div class="col-2">
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
                        <div class="col-2">
                           <div class="form-group">
                             <select name="status_approved" id="status_approved" class="form-select">
                                <option value="">- Pilih Status -</option>
                                <option value="0" {{ Request('status_approved') === '0' ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ Request('status_approved') == 1 ? 'selected' : '' }}>Disetujui</option>
                                <option value="2" {{ Request('status_approved') == 2 ? 'selected' : '' }}>Ditolak</option>
                             </select>
                           </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                    Cari data
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Izin</th>
                                    <th>NIK</th>
                                    <th>Nama Karyawan</th>
                                    <th>Jabatan</th>
                                    <th>Dept - Kantor</th>
                                    <th>Tanggal Izin</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Status Approval</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataizin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_izin }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama_lengkap }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->kode_dept }} &bull; {{ $item->kode_cabang }}</td>
                                        <td>{{ date("d-m-Y", strtotime($item->tgl_izin_dari)) }} s.d {{ date("d-m-Y", strtotime($item->tgl_izin_sampai)) }}</td>
                                        <td>{{ $item->status == "i" ? "Izin" : "Sakit" }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            @if($item->status_approved == 1)
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($item->status_approved == 2)
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status_approved == 0)
                                            <a href="#" class="approve" idpengajuan="{{$item->kode_izin}}">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                                            </a>
                                            @else
                                            <a href="/presensi/{{$item->kode_izin}}/batalkanizinsakit" class="btn btn-sm btn-danger">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up-double"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 14l-4 -4l4 -4" /><path d="M8 14l-4 -4l4 -4" /><path d="M9 10h7a4 4 0 1 1 0 8h-1" /></svg>
                                                Batalkan</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$dataizin->links('vendor.pagination.bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Validasi data ini</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('approve-izinsakit')}}" method="POST">
                @csrf
                <input type="hidden" name="idizinsakit" id="idizinsakit" class="form-control">
                <div class="form-group">
                    <select name="status_approved" id="status_approved" class="form-select">
                        <option value="1">Disetujui</option>
                        <option value="2">Ditolak</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary mt-3 float-end">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" /></svg> Submit
                    </button>
                </div>
            </form>
        </div>        
    </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        $('.approve').click(function(e){
            e.preventDefault();
            var id_pengajuan = $(this).attr('idpengajuan');
            $('#idizinsakit').val(id_pengajuan);
            $('#modal-izinsakit').modal('show');
        });

        $('#dari, #sampai').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
    });
</script>    
@endpush