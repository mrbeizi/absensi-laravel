<div class="row">
    <div class="col-12">
        <table class="table table-borderless table-sm">
            <tr>
                <td>Kode Jadwal</td>
                <td>:</td>
                <td>{{$datas->kode_jam_kerja_dept}}</td>
            </tr>
            <tr>
                <td>Kantor</td>
                <td>:</td>
                <td>{{$datas->nama_cabang}}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{$datas->nama_dept}}</td>
            </tr>
        </table>
    </div>
    <div class="col-12">
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jadwal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailjamkerdept as $item)
                <tr>
                    <td>{{$item->hari}}</td>
                    <td>{{$item->nama_jam_kerja}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>