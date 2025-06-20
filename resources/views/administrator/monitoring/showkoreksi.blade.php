<form action="{{route('koreksi-presensi-store')}}" method="POST" id="formKoreksi">
    @csrf
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="nik" value="{{$karyawan->nik}}">
            <input type="hidden" name="tanggal" value="{{$tanggal}}">
            <table class="table table-borderless table-sm table-hover">
                <tr>
                    <td>NIK</td>
                    <td>{{$karyawan->nik}}</td>
                </tr>
                <tr>
                    <td>Nama Karyawan</td>
                    <td>{{$karyawan->nama_lengkap}}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>{{date('d-m-Y', strtotime($tanggal))}}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-3">
                <select name="status" id="status" class="form-select">
                    <option value="">- Status Presensi -</option>                    
                    <option value="h" @if($presensi != null) @if($presensi->status === 'h') selected @endif @endif>Hadir</option>                    
                    <option value="a" @if($presensi != null) @if($presensi->status === 'a') selected @endif @endif>Tidak Hadir</option>                    
                </select>
            </div>
            <div class="input-icon mb-3" id="form_jam_in">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-8"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l-3 2" /><path d="M12 7v5" /></svg>
                </span>
                <input type="text" value="{{ $presensi != null ? $presensi->jam_in : '' }}" name="jam_in" id="jam_in" class="form-control" placeholder="Jam masuk">
            </div>
            <div class="input-icon mb-3" id="form_jam_out">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                </span>
                <input type="text" value="{{ $presensi != null ? $presensi->jam_out : '' }}" name="jam_out" id="jam_out" class="form-control" placeholder="Jam Pulang">
            </div>
            <div class="form-group mb-3" id="form_jam_kerja">
                <select name="kode_jam_kerja" id="kode_jam_kerja" class="form-select">
                    <option value="">- Pilih Jam Kerja -</option>
                    @foreach ($jamkerja as $item)
                        <option value="{{$item->kode_jam_kerja}}" @if($presensi != null) @if($presensi->kode_jam_kerja === $item->kode_jam_kerja) selected @endif @endif>{{$item->nama_jam_kerja}}</option>
                    @endforeach
                </select>
            </div>            
            <div class="form-group mb-3">
                <button class="btn btn-primary float-end" type="submit"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function(){
        $('#jam_in').mask("00:00");
        $('#jam_out').mask("00:00");

        function loadkondisi() {
            var status = $('#status').val();
            if(status == "a") {
                $('#form_jam_in').hide();
                $('#form_jam_out').hide();
                $('#form_jam_kerja').hide();
            } else {
                $('#form_jam_in').show();
                $('#form_jam_out').show();
                $('#form_jam_kerja').show();

            }
        }

        loadkondisi();

        $('#status').change(function(){
            loadkondisi();
        });

        $('#formKoreksi').submit(function(){
            var kode_jam_kerja = $('#kode_jam_kerja').val();
            var status = $('#status').val();

            if(status == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Status Presensi harus diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#status').focus();
                });
                return false;
            } else if(kode_jam_kerja == "" && status == "h") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam kerja harus diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 1500
                }).then((result) => {
                    $('#kode_jam_kerja').focus();
                });
                return false;
            } 
        });
    });
</script>