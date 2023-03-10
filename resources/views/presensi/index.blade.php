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
    <style>
        .webcam-capture,
        .webcam-capture video{
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 10px;
        }
        #map { 
            height: 200px; 
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endsection

@section('content')

    <div class="row" style="margin-top: 70px;">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if($check > 0)
            <button id="takeabsen" class="btn btn-info btn-block"><ion-icon name="camera"></ion-icon>Absen Pulang</button>
            @else
            <button id="takeabsen" class="btn btn-primary btn-block"><ion-icon name="camera"></ion-icon>Absen Masuk</button>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col mt-1">
            <div id="map"></div>
        </div>
    </div>
    <audio type="audio/mpeg" id="notif_in" src="{{asset('assets/audio/in.mp3')}}"></audio>
    <audio type="audio/mpeg" id="notif_out" src="{{asset('assets/audio/out.mp3')}}"></audio>
    
@endsection

@push('myscript')
<script>
    var notif_in = document.getElementById('notif_in');
    var notif_out = document.getElementById('notif_out');
    Webcam.set({
        height:480,
        width:640,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position){
        lokasi.value = position.coords.latitude+','+position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var circle = L.circle([position.coords.latitude, position.coords.longitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 20
        }).addTo(map);
    }

    function errorCallback(){

    }

    $('#takeabsen').click(function(e){
        Webcam.snap(function(uri){
            image = uri;
        });
        var lokasi = $('#lokasi').val();
        $.ajax({
            type: "POST",
            url: "/camera-snap",
            data: {
                _token: "{{csrf_token()}}",
                image:image,
                lokasi:lokasi
            },
            cache:false,
            success: function(respond){
                var status = respond.split('|');
                if(status[0] == "success"){
                    if(status[2] == "in"){
                        notif_in.play();
                    } else {
                        notif_out.play();
                    }
                    Swal.fire({
                        title: 'Success!',
                        text: status[1],
                        icon: 'success'
                    })
                    setTimeout("location.href='/dashboard'",2500);
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Sorry, data failed to save!',
                        icon: 'error'
                    })
                }
            }
        })
    });

</script>
@endpush