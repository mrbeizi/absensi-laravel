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
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-perhari" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-7"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l-2 3" /><path d="M12 7v5" /></svg>
                            &nbsp;Atur Perhari</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-pertanggal" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-calendar-week"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 2c.183 0 .355 .05 .502 .135l.033 .02c.28 .177 .465 .49 .465 .845v1h1a3 3 0 0 1 2.995 2.824l.005 .176v12a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-12a3 3 0 0 1 2.824 -2.995l.176 -.005h1v-1a1 1 0 0 1 .514 -.874l.093 -.046l.066 -.025l.1 -.029l.107 -.019l.12 -.007q .083 0 .161 .013l.122 .029l.04 .012l.06 .023c.328 .135 .568 .44 .61 .806l.007 .117v1h6v-1a1 1 0 0 1 1 -1m3 7h-14v9.625c0 .705 .386 1.286 .883 1.366l.117 .009h12c.513 0 .936 -.53 .993 -1.215l.007 -.16z" /><path d="M9.015 13a1 1 0 0 1 -1 1a1.001 1.001 0 1 1 -.005 -2c.557 0 1.005 .448 1.005 1" /><path d="M13.015 13a1 1 0 0 1 -1 1a1.001 1.001 0 1 1 -.005 -2c.557 0 1.005 .448 1.005 1" /><path d="M17.02 13a1 1 0 0 1 -1 1a1.001 1.001 0 1 1 -.005 -2c.557 0 1.005 .448 1.005 1" /><path d="M12.02 15a1 1 0 0 1 0 2a1.001 1.001 0 1 1 -.005 -2z" /><path d="M9.015 16a1 1 0 0 1 -1 1a1.001 1.001 0 1 1 -.005 -2c.557 0 1.005 .448 1.005 1" /></svg>
                            &nbsp;Atur Pertanggal</a>
                        </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tabs-perhari" role="tabpanel">
                                <form action="/konfigurasi/storesetjamkerja" method="POST">
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
                                            <tr>
                                                <td>Senin
                                                    <input type="hidden" name="hari[]" value="Senin">
                                                </td>
                                                <td>
                                                    <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                        <option value="">- Pilih- </option>
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
                                                        <option value="">- Pilih- </option>
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
                                                        <option value="">- Pilih- </option>
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
                                                        <option value="">- Pilih- </option>
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
                                                        <option value="">- Pilih- </option>
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
                                                        <option value="">- Pilih- </option>
                                                        @foreach ($jamkerja as $item)
                                                            <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Minggu
                                                    <input type="hidden" name="hari[]" value="Minggu">
                                                </td>
                                                <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                        <option value="">- Pilih- </option>
                                                        @foreach ($jamkerja as $item)
                                                            <option value="{{$item->kode_jam_kerja}}">{{$item->nama_jam_kerja}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary w-100" type="submit"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>simpan</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="tabs-pertanggal" role="tabpanel">
                                @include('administrator.konfigurasi.jamkerjapertanggalload')
                            </div>
                        </div>
                        
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
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function(){
        $('#tanggal').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $('#simpan-pertanggal').click(function(e){
            e.preventDefault();
            var nik = "{{$karyawan->nik}}";
            var tanggal = $('#tanggal').val();
            var kd_jamker = $('#kd_jamker').val();

            if(tanggal == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih tanggal!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#tanggal').focus();
                });
                return false;
            } else if(kd_jamker == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih jam kerja!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#kd_jamker').focus();
                });
                return false;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('simpan-pertanggal')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    nik: nik,
                    tanggal: tanggal,
                    kd_jamker: kd_jamker
                },
                cache: false,
                success: function(respond){
                    if(respond == 1) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Data berhasil ditambahkan!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 1500
                        }).then((result) => {
                            loadjamkerjapertanggal();
                        });
                    } else if(respond == 0) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menambahkan data!',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            timer: 1500
                        }).then((result) => {
                            loadjamkerjapertanggal();
                        });
                    }
                }
            });
        }); 
        
        function loadjamkerjapertanggal(){
            var nik = "{{$karyawan->nik}}";
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            $('#loadjamkerjapertanggal').load('/jamkerja/'+nik+'/'+bulan+'/'+tahun+'/show');
        };

        $('#bulan, #tahun').change(function(){
            loadjamkerjapertanggal();
        })

        loadjamkerjapertanggal();
    });
</script>
@endpush