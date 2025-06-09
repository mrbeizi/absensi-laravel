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
            Konfigurasi Jam Kerja Departemen
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
            <div class="col-6">
                <div class="card">
                    <div class="card-body">                        
                        <form action="/jamkerjadepartment/store" method="POST" id="formJamKerja">
                            @csrf
                            <div class="row mt-2">                                
                                <div class="col-12">
                                    <input type="hidden" value="" name="hidkodejamker" id="hidkodejamker" class="form-control">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-number-123"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 10l2 -2v8" /><path d="M9 8h3a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h3" /><path d="M17 8h2.5a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1 -1.5 1.5h-1.5h1.5a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1 -1.5 1.5h-2.5" /></svg>
                                        </span>
                                        <input type="text" value="" name="kode_jam_kerja_dept" id="kode_jam_kerja_dept" class="form-control" placeholder="auto-generated" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <select name="kode_cabang" id="kode_cabang" class="form-select">
                                            <option value="">-- Pilih Kantor --</option>
                                            @foreach($datacabang as $cab)
                                            <option {{ Request('kode_cabang') == $cab->kode_cabang ? 'selected' : '' }} value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <select name="kode_dept" id="kode_dept" class="form-select">
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach($department as $dep)
                                            <option {{ Request('kode_dept') == $dep->kode_dept ? 'selected' : '' }} value="{{ $dep->kode_dept }}">{{ $dep->nama_dept }}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="form-group mb-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Hari</th>
                                                    <th>Jam Kerja</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Senin
                                                        <input type="hidden" name="hari[]" value="Senin">
                                                    </td>
                                                    <td>
                                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                            <option value="">- Pilih - </option>
                                                            @foreach ($jamkerja as $item)
                                                                <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Selasa
                                                        <input type="hidden" name="hari[]" value="Selasa">
                                                    </td>
                                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                            <option value="">- Pilih - </option>
                                                            @foreach ($jamkerja as $item)
                                                                <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Rabu
                                                        <input type="hidden" name="hari[]" value="Rabu">
                                                    </td>
                                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                            <option value="">- Pilih - </option>
                                                            @foreach ($jamkerja as $item)
                                                                <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kamis
                                                        <input type="hidden" name="hari[]" value="Kamis">
                                                    </td>
                                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                            <option value="">- Pilih - </option>
                                                            @foreach ($jamkerja as $item)
                                                                <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jumat
                                                        <input type="hidden" name="hari[]" value="Jumat">
                                                    </td>
                                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                            <option value="">- Pilih - </option>
                                                            @foreach ($jamkerja as $item)
                                                                <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sabtu
                                                        <input type="hidden" name="hari[]" value="Sabtu">
                                                    </td>
                                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                            <option value="">- Pilih - </option>
                                                            @foreach ($jamkerja as $item)
                                                                <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                                                                      
                                    <div class="form-group tombol-simpan">
                                        <button class="btn btn-primary float-end"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Cabang</th>
                                            <th>Departemen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jamKerjaDept as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->kode_jam_kerja_dept}}</td>
                                            <td>{{$item->nama_cabang}}</td>
                                            <td>{{$item->nama_dept}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" class="show text-info" kodejamkerdept="{{$item->kode_jam_kerja_dept}}">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-.328 0 -.652 -.017 -.97 -.05c-3.172 -.332 -5.85 -2.315 -8.03 -5.95c2.4 -4 5.4 -6 9 -6c3.465 0 6.374 1.853 8.727 5.558" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                                                    </a>&nbsp;&nbsp;
                                                    <a href="#" class="edit text-success" 
                                                    kodejamkerdept="{{$item->kode_jam_kerja_dept}}" 
                                                    kodecabang="{{$item->nama_cabang}}" 
                                                    kodedept="{{$item->nama_dept}}">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                    </a>&nbsp;&nbsp;
                                                    <form action="/jamkerjadepartment/{{ $item->kode_jam_kerja_dept }}/destroy" method="POST">
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
<div class="modal modal-blur fade" id="modal-showjadwalkerjadept" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Jadwal jam kerja departemen</h5>
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
        $('.edit').click(function() {
            var kode_jam_kerja = $(this).attr('kodejamkerdept');
            var kode_cabang = $(this).attr('kodecabang');
            var kode_dept = $(this).attr('kodedept');
            $.ajax({
                type: 'POST',
                url: "/jamkerjadepartment/edit",
                cache: false,
                data:{
                    _token: "{{ csrf_token(); }}",
                    kode_jam_kerja_dept:kode_jam_kerja
                },
                success: function(respond){
                    $('#hidkodejamker').val(kode_jam_kerja);
                    $('#kode_jam_kerja_dept').val(kode_jam_kerja);
                    $('#kode_cabang').html(`
                        <div class="form-group mb-3">
                            <select name="kode_cabang" id="kode_cabang" class="form-select">
                                <option value="${kode_cabang}">${kode_cabang}</option>
                            </select>
                        </div>
                    `);
                    $('#kode_cabang').prop('disabled', true);
                    $('#kode_dept').html(`
                        <div class="form-group mb-3">
                            <select name="kode_dept" id="kode_dept" class="form-select">
                                <option value="${kode_dept}">${kode_dept}</option>
                            </select>
                        </div> 
                    `);
                    $('#kode_dept').prop('disabled', true);
                    
                    $('input[name="hari[]"]').each(function() {
                        var hari = $(this).val();
                        var selectElement = $(this).closest('tr').find('select[name="kode_jam_kerja[]"]');
                        selectElement.html('<option value="">- Pilih -</option>'); 
                        $.each(respond.data_jam_kerja, function(i, item) {
                            var selected = ""; 
                            $.each(respond.detailjamkerdept, function(j, detail) {
                                if (detail.hari === hari && detail.kode_jam_kerja === item.kode_jam_kerja) {
                                    selected = "selected";
                                }
                            });
                            selectElement.append(`<option value="${item.kode_jam_kerja}" ${selected}>${item.nama_jam_kerja}</option>`);
                        });
                    });
                    
                    $('.tombol-simpan').html(`
                    <div class="btn-group float-end">
                        <a href="{{route('jam-kerja-department')}}" class="btn btn-secondary">
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
            var kode_jam_kerja_dept = $('#kode_jam_kerja_dept').val();
            var kode_cabang = $('#kode_cabang').val();
            var kode_dept = $('#kode_dept').val();

            if(kode_cabang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih kantor!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#kode_cabang').focus();
                });
                return false;
            } else if(kode_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih departemen!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#kode_dept').focus();
                });
                return false;
            } 
        });

        $('.show').click(function(e) {
            $('#modal-showjadwalkerjadept').modal('show');
            var kode_jam_kerja = $(this).attr('kodejamkerdept');
            $.ajax({
                type: 'POST',
                url: "{{ route('show-jadwal-jamker-dept') }}",
                cache: false,
                data:{
                    _token: "{{ csrf_token(); }}",
                    kode_jam_kerja_dept:kode_jam_kerja
                },
                success: function(respond){
                    $('#loadeditform').html(respond);
                }
            });
            $('#modal-showjadwalkerjadept').modal('show');
        });
    });
</script>
@endpush