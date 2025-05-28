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
            Konfigurasi Jam Kerja
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
                        <form action="/jamkerja/store" method="POST" id="formJamKerja">
                            @csrf
                            <div class="row mt-2">                                
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <input type="hidden" value="" name="hidkodejamker" id="hidkodejamker" class="form-control">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-grid-scan"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v8" /><path d="M14 8v8" /><path d="M8 10h8" /><path d="M8 14h8" /><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /></svg>
                                        </span>
                                        <input type="text" value="" name="kode_jam_kerja" id="kode_jam_kerja" class="form-control" placeholder="Kode jam kerja">
                                    </div>
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-letter-case"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17.5 15.5m-3.5 0a3.5 3.5 0 1 0 7 0a3.5 3.5 0 1 0 -7 0" /><path d="M3 19v-10.5a3.5 3.5 0 0 1 7 0v10.5" /><path d="M3 13h7" /><path d="M21 12v7" /></svg>
                                        </span>
                                        <input type="text" value="" name="nama_jam_kerja" id="nama_jam_kerja" class="form-control" placeholder="Nama jam kerja">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-icon mb-3">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                                                </span>
                                                <input type="text" value="" name="awal_jam_masuk" id="awal_jam_masuk" class="form-control" placeholder="Awal jam masuk">
                                            </div>                                            
                                        </div>
                                        <div class="col-6">
                                            <div class="input-icon mb-3">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                                                </span>
                                                <input type="text" value="" name="jam_masuk" id="jam_masuk" class="form-control" placeholder="Jam masuk">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-icon mb-3">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                                                </span>
                                                <input type="text" value="" name="akhir_jam_masuk" id="akhir_jam_masuk" class="form-control" placeholder="Akhir jam masuk">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-icon mb-3">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                                                </span>
                                                <input type="text" value="" name="jam_pulang" id="jam_pulang" class="form-control" placeholder="Jam pulang">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group tombol-simpan">
                                        <button class="btn btn-primary float-end"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>Tambah</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Jam Kerja</th>
                                            <th>Nama Jam Kerja</th>
                                            <th>Awal Jam Kerja</th>
                                            <th>Jam Masuk</th>
                                            <th>Akhir Jam Kerja</th>
                                            <th>Jam Pulang</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jamkerja as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->kode_jam_kerja }}</td>
                                            <td>{{ $data->nama_jam_kerja }}</td>
                                            <td>{{ $data->awal_jam_masuk }}</td>
                                            <td>{{ $data->jam_masuk }}</td>
                                            <td>{{ $data->akhir_jam_masuk }}</td>
                                            <td>{{ $data->jam_pulang }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" class="edit text-success" kodejamker="{{$data->kode_jam_kerja}}" namajamker="{{$data->nama_jam_kerja}}" awaljam={{$data->awal_jam_masuk}} jammasuk="{{$data->jam_masuk}}" akhirjam="{{$data->akhir_jam_masuk}}" jampulang="{{$data->jam_pulang}}">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                    </a>&nbsp;&nbsp;
                                                    <form action="/jamkerja/{{ $data->kode_jam_kerja }}/destroy" method="POST">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        $('.edit').click(function() {
            var kode_jam_kerja = $(this).attr('kodejamker');
            var nama_jam_kerja = $(this).attr('namajamker');
            var awal_jam_masuk = $(this).attr('awaljam');
            var jam_masuk = $(this).attr('jammasuk');
            var akhir_jam_masuk = $(this).attr('akhirjam');
            var jam_pulang = $(this).attr('jampulang');
            $.ajax({
                type: 'POST',
                url: "/jamkerja/edit",
                cache: false,
                data:{
                    _token: "{{ csrf_token(); }}",
                    kode_jam_kerja:kode_jam_kerja
                },
                success: function(respond){
                    $('#hidkodejamker').val(kode_jam_kerja);
                    $('#kode_jam_kerja').val(kode_jam_kerja);
                    $('#nama_jam_kerja').val(nama_jam_kerja);
                    $('#awal_jam_masuk').val(awal_jam_masuk);
                    $('#jam_masuk').val(jam_masuk);
                    $('#akhir_jam_masuk').val(akhir_jam_masuk);
                    $('#jam_pulang').val(jam_pulang);
                    $('.tombol-simpan').html(`
                    <div class="btn-group float-end">
                        <a href="{{route('jam-kerja')}}" class="btn btn-secondary">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>Cancel                            
                        </a>&nbsp;&nbsp;
                        <button class="btn btn-primary">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>Update
                        </button>
                    </div>                    
                    `);
                }
            });
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

        $('#formJamKerja').submit(function(){
            var kode_jam_kerja = $('#kode_jam_kerja').val();
            var nama_jam_kerja = $('#nama_jam_kerja').val();
            var awal_jam_masuk = $('#awal_jam_masuk').val();
            var jam_masuk = $('#jam_masuk').val();
            var akhir_jam_masuk = $('#akhir_jam_masuk').val();
            var jam_pulang = $('#jam_pulang').val();

            if(kode_jam_kerja == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum kode jam kerja!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#kode_jam_kerja').focus();
                });
                return false;
            } else if(nama_jam_kerja == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input nama jam kerja!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#nama_jam_kerja').focus();
                });
                return false;
            } else if(awal_jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input awal jam masuk!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#awal_jam_masuk').focus();
                });
                return false;
            } else if(jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input jam masuk!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#jam_masuk').focus();
                });
                return false;
            } else if(akhir_jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input akhir jam masuk!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#akhir_jam_masuk').focus();
                });
                return false;
            } else if(jam_pulang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input jam pulang!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#jam_pulang').focus();
                });
                return false;
            }
        });
    });
</script>
@endpush