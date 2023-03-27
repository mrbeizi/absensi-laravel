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
    <div class="fab-button bottom-right" style="margin-bottom:70px">
        <a href="{{route('create-izin')}}" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
    
@endsection