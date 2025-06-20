@php
    function differ($jam_in, $jam_out){
        list($h, $m, $s) = explode(":", $jam_in);
        $dtAwal = mktime($h, $m, $s, "1", "1", "1");
        list($h, $m, $s) = explode(":", $jam_out);
        $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalMenit = $dtSelisih / 60;
        $jam = explode(".", $totalMenit / 60);
        $sisaMenit = ($totalMenit / 60) - $jam[0];
        $sisaMenit2 = $sisaMenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ":" . round($sisaMenit2);
    }
@endphp

@foreach ($presensi as $item)
    @php 
        $foto_in = Storage::url('uploads/absensi/'.$item->foto_in);
        $foto_out = Storage::url('uploads/absensi/'.$item->foto_out);
    @endphp
    @if($item->status == "h")
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->kode_dept }}</td>
            <td>{{ $item->nama_jam_kerja }} ({{$item->jam_masuk}} &ndash; {{$item->jam_pulang}})</td>
            <td>@php
                $statusLabels = [
                    'h' => '<span class="badge bg-success">Hadir</span>',
                    's' => '<span class="badge bg-danger">Sakit</span>',
                    'i' => '<span class="badge bg-warning">Izin</span>',
                    'c' => '<span class="badge bg-purple">Cuti</span>',
                    'a' => '<span class="badge bg-danger">Alfa</span>'
                ];
                @endphp

                {!! $statusLabels[$item->status] ?? '<span class="badge bg-secondary">Belum absen</span>' !!}
            </td>
            <td>{!! $item->jam_in != null ? $item->jam_in : '<span class="badge  bg-warning">Belum absen</span>' !!}</td>
            <td>
                @if($item->foto_in != null)
                <img src="{{ url($foto_in)}}" class="avatar avatar-rounded" alt="fotomasuk">
                @else
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-photo-cancel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" /><path d="M14 14l1 -1c.616 -.593 1.328 -.792 2.008 -.598" /><path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M17 21l4 -4" /></svg>
                @endif
            </td>
            <td>{!! $item->jam_out != null ? $item->jam_out : '<span class="badge bg-warning">Belum absen</span>' !!}</td>
            <td>
                @if($item->foto_out != null)
                <img src="{{ url($foto_out)}}" class="avatar avatar-rounded" alt="fotopulang">
                @else
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-photo-cancel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" /><path d="M14 14l1 -1c.616 -.593 1.328 -.792 2.008 -.598" /><path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M17 21l4 -4" /></svg>
                @endif
            </td>            
            <td>
                @if ($item->jam_in > $item->jam_masuk)
                @php
                    $jam_terlambat = differ($item->jam_masuk, $item->jam_in);
                @endphp
                    <span class="badge bg-danger">Terlambat {{$jam_terlambat}}</span>
                @else
                    <span class="badge bg-success">Good!</span>
                @endif
            </td>
            <td>
                @if ($item->location_in != NULL)
                <a href="#" class="tampilkanpeta" id="{{$item->id}}">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 18l-2 -1l-6 3v-13l6 -3l6 3l6 -3v7.5" /><path d="M9 4v13" /><path d="M15 7v5" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                </a>
                @endif
            </td>
            <td>
                <a href="#" class="koreksipresensi text-warning" nik="{{$item->nik}}">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M15 19l2 2l4 -4" /></svg>
                </a>
            </td>
        </tr>
    @else
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->kode_dept }}</td>
            <td></td>
            <td>@php
                $statusLabels = [
                    'h' => '<span class="badge bg-success">Hadir</span>',
                    's' => '<span class="badge bg-danger">Sakit</span>',
                    'i' => '<span class="badge bg-warning">Izin</span>',
                    'c' => '<span class="badge bg-purple">Cuti</span>',
                    'a' => '<span class="badge bg-danger">Alfa</span>'
                ];
                @endphp

                {!! $statusLabels[$item->status] ?? '<span class="badge bg-secondary">Belum Absen</span>' !!}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$item->keterangan}}</td>
            <td></td>
            <td>
                <a href="#" class="koreksipresensi text-warning" nik="{{$item->nik}}">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M15 19l2 2l4 -4" /></svg>
                </a>
            </td>
        </tr>
    @endif
    
@endforeach

<script>
    $(function() {
        $(".tampilkanpeta").click(function(e){
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "{{route('tampilkan-peta')}}",
                data:{
                    _token: "{{ csrf_token() }}",
                    id:id
                },
                cache: false,
                success:function(respond){
                    $('#loadpeta').html(respond);
                }
            });
            $("#modal-peta").modal('show');
        });

        $(".koreksipresensi").click(function(e){
            var nik = $(this).attr('nik');
            var tanggal = "{{$tanggal}}";
            $.ajax({
                type: "POST",
                url: "{{route('koreksi-presensi')}}",
                data:{
                    _token: "{{ csrf_token() }}",
                    nik:nik,
                    tanggal:tanggal
                },
                cache: false,
                success:function(respond){
                    $('#loadkoreksi').html(respond);
                }
            });
            $("#modal-koreksipresensi").modal('show');
        })
    });
</script>