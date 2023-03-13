@if($history->isEmpty())
    <div class="alert alert-outline-warning">
        <p style="text-align: center">No data available to show</p>
    </div>
@endif
    @foreach($history as $data)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                <div class="icon-box bg-primary">
                    <ion-icon name="finger-print" role="img" class="md hydrated"
                        aria-label="finger print"></ion-icon>
                </div>
                <div class="in">
                    <div>{{date('d-m-Y',strtotime($data->tgl_presensi))}}</div>
                    <span class="badge {{$data->jam_in < "07:00" ? "badge-success" : "badge-danger"}}">{{$data->jam_in}}</span>
                    <span class="badge badge-primary">{{$data->jam_out}}</span>
                </div>
            </div>
        </li>
    </ul>
    @endforeach