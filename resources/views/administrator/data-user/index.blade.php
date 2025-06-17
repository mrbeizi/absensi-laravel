@extends('layouts.admin.tabler')
@section('title','Data User')

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
            Data User
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
                                <a href="javascript:void()" class="btn btn-primary" id="btnTambahUser">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="{{route('data-user')}}" method="GET">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="text" name="nama_user" class="form-control" placeholder="Nama User" value="{{ Request('nama_user') }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg> Cari</button>
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
                                            <th>Nama User</th>
                                            <th>Email</th>
                                            <th>Departemen</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $number => $item)
                                        <tr>
                                            <td>{{ ++$number }}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->nama_dept}}</td>
                                            <td>{{$item->role}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" class="edit text-success" dataid="{{$item->id}}">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                    </a>&nbsp;&nbsp;
                                                    <form action="/data-user/{{ $item->id }}/destroy" method="POST">
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
<div class="modal modal-blur fade" id="modal-inputUser" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Tambah Data User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/data-user/store" method="POST" id="formUser">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            </span>
                            <input type="text" value="" name="name" id="name" class="form-control" placeholder="Nama User">
                        </div>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-at"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28" /></svg>
                            </span>
                            <input type="text" value="" name="email" id="email" class="form-control" placeholder="Alamat email">
                        </div>
                        <div class="input-icon mb-3">                                        
                            <select name="kode_dept" id="kode_dept" class="form-select">
                                <option value="">- Pilih Departemen -</option>
                                @foreach ($department as $d)
                                    <option value="{{$d->kode_dept}}">{{$d->nama_dept}}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <div class="input-icon mb-3">                                        
                            <select name="role" id="role" class="form-select">
                                <option value="">- Pilih Role -</option>
                                @foreach ($roles as $r)
                                    <option value="{{$r->name}}">{{$r->name}}</option>
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
{{-- Modal edit departemen --}}
<div class="modal modal-blur fade" id="modal-edituser" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Data Departemen</h5>
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
        $('#btnTambahUser').click(function() {
            $('#modal-inputUser').modal('show');
        });

        $('.edit').click(function() {
            var iduser = $(this).attr('dataid');
            $.ajax({
                type: 'POST',
                url: "/data-user/edit",
                cache: false,
                data:{
                    _token: "{{ csrf_token(); }}",
                    id:iduser
                },
                success: function(respond){
                    $('#loadeditform').html(respond);
                }
            });
            $('#modal-edituser').modal('show');
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

        $('#formUser').submit(function(){
            var name = $('#name').val();
            var email = $('#email').val();
            var kode_dept = $('#kode_dept').val();
            var role = $('#role').val();

            if(name == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input nama user!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#name').focus();
                });
                return false;
            } else if(email == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum input alamat email user!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#email').focus();
                });
                return false;
            } else if(kode_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih departemen',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#kode_dept').focus();
                });
                return false;
            } else if(role == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih role',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#role').focus();
                });
                return false;
            } 
        });
    });
</script>
@endpush