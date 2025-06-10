@extends('layouts.resources')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <style>
        .historicontent{
            display: flex;
        }
        .dataizin {
            margin-left: 10px;
        }
        .dataizin h3 {
            line-height: 3px;
        }
        #statusizin {
            position: absolute;
            right: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="col ml-2 mr-2 mb-1">
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>                
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{Session::get('error')}}
                </div>                
            @endif
        </div>        
    </div>
    <div class="row">
        <div class="col ml-2 mr-2">
            @foreach($datas as $data)
            <div class="card mb-1">
                <div class="card-body">
                    <div class="historicontent">
                        <div class="iconpresensi">
                            @if($data->status == "i")
                            <ion-icon name="document-text-outline" role="img" class="md hydrated text-primary" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                            @elseif($data->status == "s")
                            <ion-icon name="medkit-outline" role="img" class="md hydrated text-danger" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                            @else
                            <ion-icon name="hourglass-outline" role="img" class="md hydrated text-primary" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                            @endif
                        </div>
                        <div class="dataizin">
                            <h3>{{date("d-m-Y", strtotime($data->tgl_izin_dari))}} ({{ ($data->status == "i") ? "Izin" : (($data->status == "s") ? "Sakit" : (($data->status == "c") ? "Cuti" : "Data not found")) }})</h3>
                            <small>{{date("d-m-Y", strtotime($data->tgl_izin_dari))}} s.d {{date("d-m-Y", strtotime($data->tgl_izin_sampai))}}</small>
                            <p>{{$data->keterangan}}<br>
                                @if(!empty($data->docs_sid))
                                <small class="text-primary"><ion-icon name="document-attach-outline"></ion-icon> Lihat SID</small>
                                @endif</p>
                        </div>
                        <div class="mt-2" id="statusizin">
                            @if($data->status_approved == 0)
                            <span class="badge badge-warning">Pending</span>
                            @elseif($data->status_approved == 1)
                            <span class="badge badge-success">Approved</span>
                            @else
                            <span class="badge badge-danger">Rejected</span>
                            @endif
                            <p style="margin-top: 5px; font-weight: bold;">{{countDay($data->tgl_izin_dari,$data->tgl_izin_sampai)}} Hari</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    {{-- <div class="fab-button bottom-right" style="margin-bottom:70px">
        <a href="{{route('create-izin')}}" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div> --}}
    <div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px;">
        <a href="#" class="fab bg-primary" data-toggle="dropdown">
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
        <div class="dropdown-menu">
            <a href="{{route('index-izinabsen')}}" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="image outline"></ion-icon>
                <p>Izin Absen</p>
            </a>
            <a href="{{route('index-izinsakit')}}" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="videocam outline"></ion-icon>
                <p>Sakit</p>
            </a>
            <a href="" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="videocam outline"></ion-icon>
                <p>Cuti</p>
            </a>
        </div>
    </div>
    
@endsection