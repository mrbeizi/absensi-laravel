@extends('layouts.admin.tabler')
@section('title','Laporan Presensi')

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
            Laporan Presensi
        </h2>
        </div>        
    </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('cetaklaporan-presensi')}}" method="POST" target="_blank" id="formLaporan">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <select name="bulan" id="bulan" class="form-select">
                                            <option value="">- Pilih Bulan -</option>
                                            @for($i=1; $i<=12; $i++)
                                                <option value="{{$i}}" {{ date('m') == $i ? 'selected' : ''}}>{{$monthName[$i]}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <select name="tahun" id="tahun" class="form-select">
                                            <option value="">- Pilih Tahun -</option>
                                            @php
                                                $startYear = 2024;
                                                $endYear = date('Y');
                                            @endphp
                                            @for($tahun=$startYear; $tahun<=$endYear; $tahun++)
                                                <option value="{{$tahun}}" {{ date('Y') == $tahun ? 'selected' : ''}}>{{$tahun}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <select name="nik" id="nik" class="form-select">
                                            <option value="">- Pilih Karyawan -</option>
                                            @foreach($karyawan as $data)
                                            <option value="{{$data->nik}}">{{$data->nama_lengkap}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" name="cetak">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                                            Cetak
                                        </button>
                                        <button class="btn btn-success" type="submit" name="exportexcel">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                                            Export to Excel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        $('#formLaporan').submit(function(e){
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();
            var nik = $("#nik").val();

            if(bulan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih bulan!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#bulan').focus();
                });
                return false;
            } else if(tahun == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih tahun!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#tahun').focus();
                });
                return false;
            } else if(nik == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Anda belum memilih NIK!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#nik').focus();
                });
                return false;
            }
        });
    });
</script>    
@endpush