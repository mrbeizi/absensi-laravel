<div class="row">
    <div class="col-8">
        <div class="form-group">
            <select name="bulan" id="bulan" class="form-select">
                <option value="">- Pilih Bulan -</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{$i}}" {{ date('m') == $i ? 'selected' : ''}}>{{$monthName[$i]}}</option>
                @endfor
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <select name="tahun" id="tahun" class="form-select">
                <option value="">- Pilih Tahun -</option>
                @php
                    $startYear = 2024;
                    $endYear = date('Y');
                @endphp
                @for($tahun=$startYear; $tahun<=$endYear; $tahun++)
                    <option value="{{$tahun}}" {{ date('Y') == $tahun ? 'selected' : ''}}>{{$tahun}}</option>
                @endfor
            </select>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-6">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                    </span>
                    <input type="text" value="" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal" autocomplete="off">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select name="kd_jamker" id="kd_jamker" class="form-select">
                        <option value="">- Pilih Jam Kerja -</option>
                        @foreach ($jamkerja as $j)
                            <option value="{{$j->kode_jam_kerja}}">{{$j->nama_jam_kerja}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <button id="simpan-pertanggal" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Kode Jam Kerja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="loadjamkerjapertanggal"></tbody>
        </table>
    </div>
</div>