@extends('layouts.resources')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pilih Jam Kerja</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            <style>
                .historicontent{
                    display: flex;
                    color: black;
                }
                .datapresensi {
                    margin-left: 10px;
                }
                .datapresensi h3 {
                    line-height: 3px;
                }
                #keterangan {
                    margin-top: 0px !important;
                }
            </style>
            @foreach($jamkerja as $item)
                <a href="{{route('camera',['code' => Crypt::encrypt($item->kode_jam_kerja)])}}">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="historicontent">
                                <div class="iconpresensi">
                                    <ion-icon name="finger-print" role="img" class="md hydrated text-success" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                                </div>
                                <div class="datapresensi">
                                    <h3>{{$item->nama_jam_kerja}}</h3>
                                    <span>Jam masuk: {{date('H:i',strtotime($item->jam_masuk))}}</span><br>
                                    <span>Jam pulang: {{date('H:i',strtotime($item->jam_pulang))}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>   
@endsection