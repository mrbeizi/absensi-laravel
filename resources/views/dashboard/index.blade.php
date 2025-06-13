@extends('layouts.resources')

@section('content')
<style>
    .logout {
        position: absolute;
        color: white;
        font-size: 30px;
        right: 20px;
        top: 40px;
    }
    .logout:hover {
        color: white;
    }
</style>
    <div class="section" id="user-section">
        <a href="{{route('proses-logout')}}" class="logout">
            <ion-icon name="exit-outline"></ion-icon>
        </a>
        <div id="user-detail">
            <div class="avatar">
                @if(!empty(Auth::guard('karyawan')->user()->foto))
                    @php
                        $path = Storage::url('uploads/karyawan/'.Auth::guard('karyawan')->user()->foto);
                    @endphp
                    <img src="{{url($path)}}" alt="avatar" class="imaged w64" style="height:62px;">
                    @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h3 id="user-name">{{Auth::guard('karyawan')->user()->nama_lengkap}}</h3>
                <span id="user-role">{{Auth::guard('karyawan')->user()->jabatan}} ({{Auth::guard('karyawan')->user()->kode_cabang}})</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{route('edit-profile')}}" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{route('presensi-izin')}}" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{route('presensi-history')}}" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section" style="position: fixed; width: 100%; margin: auto; overflow-y: scroll; height: 620px;">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if($todayPresence != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/'.$todayPresence->foto_in);
                                        @endphp
                                        <img src="{{url($path)}}" alt="image" class="imaged w44">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{$todayPresence != null ? $todayPresence->jam_in : 'Belum Absen'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if($todayPresence != null && $todayPresence->jam_out != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/'.$todayPresence->foto_out);
                                        @endphp
                                        <img src="{{url($path)}}" alt="image" class="imaged w44">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{$todayPresence != null && $todayPresence->jam_out != null ? $todayPresence->jam_out : 'Belum Absen'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="presencerecap">
            <h4>Presence Recap for {{ $monthName[date('m')*1] }} {{$yearNow}}</h4>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-danger" style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">{{$recapData->jmlhadir}}</span>
                            <ion-icon name="checkmark-circle" style="font-size: 1.4rem" class="text-success"></ion-icon><br>
                            <span style="font-size: 0.5rem">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-danger" style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">@if($recapData->jmlizin == 0) 0 @else{{$recapData->jmlizin}} @endif</span>
                            <ion-icon name="remove-circle" style="font-size: 1.4rem" class="text-primary"></ion-icon><br>
                            <span style="font-size: 0.5rem">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-danger" style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">@if($recapData->jmlsakit == 0) 0 @else {{$recapData->jmlsakit}} @endif</span>
                            <ion-icon name="sad" style="font-size: 1.4rem" class="text-warning"></ion-icon><br>
                            <span style="font-size: 0.5rem">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 10px 8px !important; line-height:0.8rem;">
                            <span class="badge badge-danger" style="position:absolute; top:2px; right:5px; font-size:0.7rem; z-index:999;">{{$recapData->jmlcuti}}</span>
                            <ion-icon name="calendar-outline" style="font-size: 1.4rem" class="text-danger"></ion-icon><br>
                            <span style="font-size: 0.5rem">Cuti</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    {{-- <ul class="listview image-listview">
                        @foreach($historyPerMonth as $history)
                        <li>
                            <div class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="finger-print" role="img" class="md hydrated"
                                        aria-label="finger print"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>{{date('d-m-Y',strtotime($history->tgl_presensi))}}</div>
                                    <span class="badge badge-success">{{$history->jam_in}}</span>
                                    <span class="badge badge-danger">{{$todayPresence != null && $todayPresence->jam_out != null ? $todayPresence->jam_out : 'Belum Absen'}}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul> --}}
                    <style>
                        .historicontent{
                            display: flex;
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
                    @foreach($historyPerMonth as $history)
                        @if($history->status == "h")
                            <div class="card mb-1">
                                <div class="card-body">
                                    <div class="historicontent">
                                        <div class="iconpresensi">
                                            <ion-icon name="finger-print" role="img" class="md hydrated text-success" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                                        </div>
                                        <div class="datapresensi">
                                            <h3>{{$history->nama_jam_kerja}}</h3>
                                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($history->tgl_presensi))}}</h4>
                                            <span>
                                                {!! $history->jam_in != null ? date("H:i", strtotime($history->jam_in)) : '<span class="text-danger">Belum scan</span>' !!}
                                            </span>
                                            <span>
                                                {!! $history->jam_out != null ? "-". date("H:i", strtotime($history->jam_out)) : '<span class="text-danger"> - Belum scan</span>' !!}
                                            </span><br>
                                            <div class="mt-2" id="keterangan">
                                                @php
                                                    $jam_in = date("H:i", strtotime($history->jam_in));
                                                    $jam_masuk = date("H:i", strtotime($history->jam_masuk));
                                                    $sch_jam_in = $history->tgl_presensi." ".$jam_masuk;
                                                    $jam_presensi = $history->tgl_presensi." ".$jam_in;
                                                @endphp
                                                @if($jam_in > $jam_masuk)
                                                @php
                                                    $telat = selisih($sch_jam_in, $jam_presensi);
                                                @endphp
                                                <span class="text-danger">Terlambat {{$telat}}</span>
                                                @else
                                                <span class="text-success">Good</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($history->status == "i")
                        <div class="card mb-1">
                                <div class="card-body">
                                    <div class="historicontent">
                                        <div class="iconpresensi">
                                            <ion-icon name="document-outline" role="img" class="md hydrated text-info" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                                        </div>
                                        <div class="datapresensi">
                                            <h3>Izin - [{{$history->kode_izin}}]</h3>
                                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($history->tgl_presensi))}}</h4>
                                            <span>{{$history->keterangan}}</span>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        @elseif($history->status == "c")
                        <div class="card mb-1">
                                <div class="card-body">
                                    <div class="historicontent">
                                        <div class="iconpresensi">
                                            <ion-icon name="calendar-outline" role="img" class="md hydrated text-primary" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                                        </div>
                                        <div class="datapresensi">
                                            <h3>Cuti - [{{$history->kode_izin}}]</h3>
                                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($history->tgl_presensi))}}</h4>
                                            <span class="text-primary">{{$history->nama_cuti}}</span><br>
                                            <span>{{$history->keterangan}}</span>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        @elseif($history->status == "s")
                        <div class="card mb-1">
                                <div class="card-body">
                                    <div class="historicontent">
                                        <div class="iconpresensi">
                                            <ion-icon name="medkit-outline" role="img" class="md hydrated text-danger" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                                        </div>
                                        <div class="datapresensi">
                                            <h3>Sakit - [{{$history->kode_izin}}]</h3>
                                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($history->tgl_presensi))}}</h4>
                                            <span>{{$history->keterangan}}</span><br>
                                            @if(!empty($history->docs_sid))
                                            <span style="color: blue">
                                                <ion-icon name="document-attach-outline"></ion-icon> SID
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        </div>


                        @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderBoard as $leadboard)
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div><b>{{$leadboard->nama_lengkap == Auth::guard('karyawan')->user()->nama_lengkap ? 'Me' : $leadboard->nama_lengkap}}</b><br><small class="text-muted" style="font-size: 11px;">{{$leadboard->jabatan}}</small></div>
                                    <span class="badge {{$leadboard->jam_in < "07:00" ? "badge-success" : "badge-danger"}}">{{$leadboard->jam_in}}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>

@endsection