@extends('layouts.resources')

@section('header')
<style type="text/css">
    .datepicker {
        font-size: 1em;
    }

    table.table-condensed{
        margin-top: 20px !important;
    }
    /* solution 2: the original datepicker use 20px so replace with the following:*/
    
    .datepicker td, .datepicker th {
        width: 1.5em;
        height: 1.5em;
    }
    
</style>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin Cuti</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="col">
            <form action="{{route('store-izincuti')}}" method="POST" class="ml-2 mr-2" id="formIzin">
                @csrf
                <div class="form-group">
                    <input type="text" name="tgl_izin_dari" autocomplete="off" id="tgl_izin_dari" data-date-format="yyyy/mm/dd" class="form-control datepicker" placeholder=" Dari">
                </div>
                <div class="form-group">
                    <input type="text" name="tgl_izin_sampai" autocomplete="off" id="tgl_izin_sampai" data-date-format="yyyy/mm/dd" class="form-control datepicker" placeholder=" Sampai">
                </div>
                <div class="form-group">
                    <input type="hidden" name="jumlah_hari" id="jumlah_hari" class="form-control" autocomplete="off" placeholder="Jumlah hari" readonly>
                    <small><p id="infojumlahhari" class="text-info"></p></small>
                </div>
                <div class="form-group">
                    <select name="kode_cuti" id="kode_cuti" class="form-select custom-select">
                        <option value=""> Pilih Jenis Cuti</option>
                        @foreach ($datacuti as $item)
                        <option value="{{$item->kode_cuti}}">{{$item->nama_cuti}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" name="max_cuti" id="max_cuti" class="form-control" autocomplete="off" readonly placeholder="Sisa cuti">
                    <small><p id="infomaxcuti" class="text-info"></p></small>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Tulis keterangan"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">KIRIM</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
<script>
    $('.datepicker').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
    });
    $('#datepicker').datepicker("setDate", new Date());

    function loadjumlahhari() {
        var dari = $('#tgl_izin_dari').val();
        var sampai = $('#tgl_izin_sampai').val();
        var date1 = new Date(dari);
        var date2 = new Date(sampai);

        var Diff_in_time = date2.getTime() - date1.getTime();
        var Diff_in_days = Diff_in_time / (1000 * 3600 * 24);
        if(dari == "" || sampai == ""){
            var jumlah_hari = 0;
        } else {
            var jumlah_hari = Diff_in_days + 1;
        }
        $('#jumlah_hari').val(jumlah_hari +" hari");
        $('#infojumlahhari').html('Total hari ' + jumlah_hari + ' hari.');
    }

    $('#tgl_izin_dari, #tgl_izin_sampai').change(function(e) {
        loadjumlahhari();
    });

    $('#tgl_izin_dari, #tgl_izin_sampai').change(function(e){
        var tglizin = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{route('cekdata-pengajuan-izin')}}",
            data:{
                _token: "{{ csrf_token() }}",
                tgl_izin: tglizin
            },
            cache: false,
            success:function(respond){
                if(respond == 1){
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Anda sudah mengajukan izin pada tanggal tersebut!',
                        icon: 'warning'
                    }).then((result) => {
                        $('#tgl_izin').val("");
                    });
                }
            }
        });
    });

    $('#formIzin').submit(function(){
        var tgl_izin_dari = $('#tgl_izin_dari').val();
        var tgl_izin_sampai = $('#tgl_izin_sampai').val();
        var kode_cuti = $('#kode_cuti').val();
        var keterangan = $('#keterangan').val();
        var jhari = $('#jumlah_hari').val();
        var maxcuti = $('#max_cuti').val();

        if(tgl_izin_dari == "" || tgl_izin_sampai == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Tanggal harus diisi',
                icon: 'warning'
            });
            return false;
        } else if(kode_cuti == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Jenis cuti harus diisi',
                icon: 'warning'
            });
            return false;
        } else if(keterangan == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Keterangan harus diisi',
                icon: 'warning'
            });
            return false;
        } else if(parseInt(jhari) > parseInt(maxcuti)){
            Swal.fire({
                title: 'Oops!',
                text: 'Pengajuan cuti tidak boleh lebih dari ' +maxcuti+ ' hari!',
                icon: 'warning'
            });
            return false;
        }
    });

    $('#kode_cuti').change(function(e){
        e.preventDefault();
        var kode_cuti = $(this).val();
        var tgl_izin_dari = $('#tgl_izin_dari').val();

        if(tgl_izin_dari == "" || tgl_izin_sampai == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Silahkan pilih tanggal terlebih dahulu',
                icon: 'warning'
            });
            $('#kode_cuti').val("");
        } else {
            $.ajax({
                url: "{{route('getmaxcuti')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_cuti: kode_cuti,
                    tgl_izin_dari: tgl_izin_dari
                },
                cache:false,
                success: function(respond){
                    $("#max_cuti").val(respond);
                    $('#infomaxcuti').html('Maksimal cuti anda ' + respond + ' hari.');
                }
            });
        }

    });
</script>
@endpush