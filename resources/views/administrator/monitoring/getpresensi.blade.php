@php
    function selisih($jam_in, $jam_out){
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
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nik }}</td>
        <td>{{ $item->nama_lengkap }}</td>
        <td>{{ $item->kode_dept }}</td>
        <td>{{ $item->nama_jam_kerja }} ({{$item->jam_masuk}} &ndash; {{$item->jam_pulang}})</td>
        <td>{!! $item->jam_in != null ? $item->jam_in : '<span class="badge  bg-warning">Belum absen</span>' !!}</td>
        <td><img src="{{ url($foto_in)}}" class="avatar avatar-rounded" alt="fotomasuk"></td>
        <td>{!! $item->jam_out != null ? $item->jam_out : '<span class="badge bg-warning">Belum absen</span>' !!}</td>
        <td>
            @if($item->jam_out != null)
            <img src="{{ url($foto_out)}}" class="avatar avatar-rounded" alt="fotopulang">
            @else
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass-high"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.5 7h11" /><path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" /><path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" /></svg>
            @endif
        </td>
        <td>
            @if ($item->jam_in >= $item->jam_masuk)
            @php
                $jam_terlambat = selisih($item->jam_masuk, $item->jam_in);
            @endphp
                <span class="badge bg-danger">Terlambat {{$jam_terlambat}}</span>
            @else
                <span class="badge bg-success">Good!</span>
            @endif
        </td>
        <td>
            <a href="#" class="tampilkanpeta" id="{{$item->id}}">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 18l-2 -1l-6 3v-13l6 -3l6 3l6 -3v7.5" /><path d="M9 4v13" /><path d="M15 7v5" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
            </a>
        </td>
    </tr>
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
        })
    });
</script>