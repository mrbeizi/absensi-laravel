@extends('layouts.admin.tabler')
@section('title','Data Karyawan')

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
            Data Karyawan
        </h2>
        </div>        
    </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
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
                                <form action="{{route('index-karyawan')}}" method="GET">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Karyawan" value="{{ Request('nama_lengkap') }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <select name="kode_dept" id="kode_dept" class="form-select">
                                                    <option value="">-- Pilih Department --</option>
                                                    @foreach($department as $dept)
                                                    <option {{ Request('kode_dept') == $dept->kode_dept ? 'selected' : '' }} value="{{ $dept->kode_dept }}">{{ $dept->nama_dept }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <select name="kd_cabang" id="kd_cabang" class="form-select">
                                                    <option value="">-- Pilih Kantor --</option>
                                                    @foreach($datacabang as $cab)
                                                    <option {{ Request('kd_cabang') == $cab->kode_cabang ? 'selected' : '' }} value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg> Cari data</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>No HP</th>
                                            <th>Foto</th>
                                            <th>Departemen</th>
                                            <th>Kantor</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawan as $item)
                                        @php 
                                            $path = Storage::url('uploads/karyawan/' .$item->foto);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration + $karyawan->firstItem()-1 }}</td>
                                            <td>{{$item->nik}}</td>
                                            <td>{{$item->nama_lengkap}}</td>
                                            <td>{{$item->jabatan}}</td>
                                            <td>{{$item->no_telp}}</td>
                                            <td>
                                                @if(empty($item->foto))
                                                <img src="{{asset('assets/img/nophoto.png')}}" alt="" class="avatar avatar-rounded">
                                                @else
                                                <img src="{{url($path)}}" alt="foto" class="avatar avatar-rounded">
                                                @endif
                                            </td>
                                            <td>{{$item->nama_dept}}</td>
                                            <td>{{$item->nama_cabang}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/karyawan/{{ $item->nik }}/setjamkerja" class="setting text-primary">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.003 21c-.732 .001 -1.465 -.438 -1.678 -1.317a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c.886 .215 1.325 .957 1.318 1.694" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                                                    </a>&nbsp;&nbsp;
                                                    <a href="#" class="edit text-success" nik="{{$item->nik}}">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                    </a>&nbsp;&nbsp;
                                                    <form action="/karyawan/{{ $item->nik }}/destroy" method="POST">
                                                        @csrf
                                                        <a href="http://" class="confirm-delete text-danger">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$karyawan->links('vendor.pagination.bootstrap-5')}}
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
        <h5 class="modal-title">Tambah Data Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/karyawan/store" method="POST" id="formKaryawan" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-number-123"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 10l2 -2v8" /><path d="M9 8h3a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h3" /><path d="M17 8h2.5a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1 -1.5 1.5h-1.5h1.5a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1 -1.5 1.5h-2.5" /></svg>
                            </span>
                            <input type="text" value="" name="nik" id="nik" class="form-control" placeholder="NIK">
                        </div>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="7" r="4"></circle><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                            </span>
                            <input type="text" value="" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
                        </div>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-tie"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 22l4 -4l-2.5 -11l.993 -2.649a1 1 0 0 0 -.936 -1.351h-3.114a1 1 0 0 0 -.936 1.351l.993 2.649l-2.5 11l4 4z" /><path d="M10.5 7h3l5 5.5" /></svg>
                            </span>
                            <input type="text" value="" name="jabatan" id="jabatan" class="form-control" placeholder="Jabatan">
                        </div>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                            </span>
                            <input type="text" value="" name="no_telp" id="no_telp" class="form-control" placeholder="No. Telephone/WA">
                        </div>
                        <div class="mb-3">
                            <div class="form-label">
                                <input type="file" name="foto" id="foto" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <select name="kode_dept" id="kode_dept" class="form-select">
                                <option value="">- Pilih Department -</option>
                                @foreach($department as $dept)
                                    <option {{ Request('kode_dept') == $dept->kode_dept ? 'selected' : '' }} value="{{ $dept->kode_dept }}">{{ $dept->nama_dept }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="kode_cabang" id="kode_cabang" class="form-select">
                                <option value="">- Pilih Kantor -</option>
                                @foreach($datacabang as $cab)
                                    <option {{ Request('kode_cabang') == $cab->kode_cabang ? 'selected' : '' }} value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary float-end"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>simpan</button>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
        
    </div>
    </div>
</div>
{{-- Modal edit karyawan --}}
<div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Data Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadeditform"></div>        
    </div>
    </div>
</div>

@endsection
@push('myscript')
<script>
    $(function() {
        $('#nik').mask("0000.0.000");
        $('#btnTambahKaryawan').click(function() {
            $('#modal-inputkaryawan').modal('show');
        });

        $('.edit').click(function() {
            var nik = $(this).attr('nik');
            $.ajax({
                type: 'POST',
                url: "/karyawan/edit",
                cache: false,
                data:{
                    _token: "{{ csrf_token(); }}",
                    nik:nik
                },
                success: function(respond){
                    $('#loadeditform').html(respond);
                }
            });
            $('#modal-editkaryawan').modal('show');
        });

        $('.confirm-delete').click(function(e){
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: "Do you want to delete this data?",
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire("Deleted!","Your data has been deleted.", "success");
                } 
            });
        });

        $('#formKaryawan').submit(function(){
            var nik = $('#nik').val();
            var nama_lengkap = $('#nama_lengkap').val();
            var jabatan = $('#jabatan').val();
            var no_telp = $('#no_telp').val();
            var kode_dept = $('#formKaryawan').find('#kode_dept').val();

            if(nik == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input NIK!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#nik').focus();
                });
                return false;
            } else if(nama_lengkap == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input nama lengkap!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#nama_lengkap').focus();
                });
                return false;
            } else if(jabatan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input jabatan!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#jabatan').focus();
                });
                return false;
            } else if(no_telp == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input no telpon!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#no_telp').focus();
                });
                return false;
            } else if(kode_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input departmen!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#kode_dept').focus();
                });
                return false;
            }
        });
    });
</script>
@endpush