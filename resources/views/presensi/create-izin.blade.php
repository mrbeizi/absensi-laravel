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
        <div class="pageTitle">Form Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="col">
            <form action="{{route('store-izin')}}" method="POST" class="ml-2 mr-2" id="formIzin">
                @csrf
                <div class="form-group">
                    <input type="text" name="tgl_izin" id="tgl_izin" data-date-format="yyyy/mm/dd" class="form-control datepicker" placeholder=" Tanggal">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="" class="text-muted">- Pilih -</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Tulis keterangan"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
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

    $('#tgl_izin').change(function(e){
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
        var tgl_izin = $('#tgl_izin').val();
        var status = $('#status').val();
        var keterangan = $('#keterangan').val();

        if(tgl_izin == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Tanggal harus diisi',
                icon: 'warning'
            });
            return false;
        } else if(status == ""){
            Swal.fire({
                title: 'Oops!',
                text: 'Jenis izin harus diisi',
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
        }
    });
</script>
@endpush