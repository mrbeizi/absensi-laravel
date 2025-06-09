@extends('layouts.resources')
@section('header')
     <!-- App Header -->
     <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')

    <div class="row" style="margin-top: 70px; text-align: center;">
        <div class="col">
            <div class="alert alert-warning">
                <p>
                    Maaf, anda tidak memiliki jadwal hari ini.<br>Silahkan hubungi HRD anda untuk kendala ini!
                </p>
            </div>
        </div>
    </div>
    
@endsection