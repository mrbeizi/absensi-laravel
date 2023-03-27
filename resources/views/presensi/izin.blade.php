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
@endsection
@section('content')
    <div class="row" style="margin-top: 5rem">
        <div class="col ml-2 mr-2">
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
    @foreach($datas as $data)
    <div class="row">
        <div class="col ml-2 mr-2">
            <ul class="listview image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div><b>{{date('d-m-Y',strtotime($data->tgl_izin))}}</b> ({{$data->status == "s" ? "Sakit" : "Izin"}})</br>
                                <small class="text-muted">{{$data->keterangan}}</small>
                            </div>
                            @if($data->status_approved == 0)
                            <span class="badge badge-warning">Pending</span>
                            @elseif($data->status_approved == 1)
                            <span class="badge badge-success">Approved</span>
                            @else
                            <span class="badge badge-danger">Rejected</span>
                            @endif
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    @endforeach
    <div class="fab-button bottom-right" style="margin-bottom:70px">
        <a href="{{route('create-izin')}}" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
    
@endsection