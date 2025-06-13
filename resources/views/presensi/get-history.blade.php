@if($history->isEmpty())
    <div class="alert alert-outline-warning">
        <p style="text-align: center">No data available to show</p>
    </div>
@endif
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
    .card {
        border: 0.5px solid rgb(226, 226, 226);
    }
</style>
    @foreach($history as $data)
        @if($data->status == "h")
            <div class="card mb-1">
                <div class="card-body">
                    <div class="historicontent">
                        <div class="iconpresensi">
                            <ion-icon name="finger-print" role="img" class="md hydrated text-success" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                        </div>
                        <div class="datapresensi">
                            <h3>{{$data->nama_jam_kerja}}</h3>
                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($data->tgl_presensi))}}</h4>
                            <span>
                                {!! $data->jam_in != null ? date("H:i", strtotime($data->jam_in)) : '<span class="text-danger">Belum scan</span>' !!}
                            </span>
                            <span>
                                {!! $data->jam_out != null ? "-". date("H:i", strtotime($data->jam_out)) : '<span class="text-danger"> - Belum scan</span>' !!}
                            </span><br>
                            <div class="mt-2" id="keterangan">
                                @php
                                    $jam_in = date("H:i", strtotime($data->jam_in));
                                    $jam_masuk = date("H:i", strtotime($data->jam_masuk));
                                    $sch_jam_in = $data->tgl_presensi." ".$jam_masuk;
                                    $jam_presensi = $data->tgl_presensi." ".$jam_in;
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
        @elseif($data->status == "i")
        <div class="card mb-1">
                <div class="card-body">
                    <div class="historicontent">
                        <div class="iconpresensi">
                            <ion-icon name="document-outline" role="img" class="md hydrated text-info" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                        </div>
                        <div class="datapresensi">
                            <h3>Izin - [{{$data->kode_izin}}]</h3>
                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($data->tgl_presensi))}}</h4>
                            <span>{{$data->keterangan}}</span>
                        </div>
                    </div>
                </div>
        </div>

        @elseif($data->status == "c")
        <div class="card mb-1">
                <div class="card-body">
                    <div class="historicontent">
                        <div class="iconpresensi">
                            <ion-icon name="calendar-outline" role="img" class="md hydrated text-primary" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                        </div>
                        <div class="datapresensi">
                            <h3>Cuti - [{{$data->kode_izin}}]</h3>
                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($data->tgl_presensi))}}</h4>
                            <span class="text-primary">{{$data->nama_cuti}}</span><br>
                            <span>{{$data->keterangan}}</span>
                        </div>
                    </div>
                </div>
        </div>

        @elseif($data->status == "s")
        <div class="card mb-1">
                <div class="card-body">
                    <div class="historicontent">
                        <div class="iconpresensi">
                            <ion-icon name="medkit-outline" role="img" class="md hydrated text-danger" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                        </div>
                        <div class="datapresensi">
                            <h3>Sakit - [{{$data->kode_izin}}]</h3>
                            <h4  style="margin: 0px; !important">{{date("d-m-Y", strtotime($data->tgl_presensi))}}</h4>
                            <span>{{$data->keterangan}}</span><br>
                            @if(!empty($data->docs_sid))
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