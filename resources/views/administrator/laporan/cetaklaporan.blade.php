<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Presensi</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    body{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    @page { 
        size: A4 
    }

    #title {
        font-size: 18px;
        font-weight: bold;
    }
    .tablekaryawan{
        margin-top: 3rem;
    }
    .tablepresensi {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }
    .tablepresensi tr th {
        border: 0px solid #ddd;
        padding: 8px;
        background-color: azure;
    }
    .tablepresensi tr td {
        border: 0px solid #ddd;
        padding: 8px;
        font-size: 12px;
        text-align: center;
    }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
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

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
    <table style="width: 100%">
        <tr>
            <td style="width: 30px;">
                <img src="{{asset('assets/img/logo-b.png')}}" alt="logopresensi" width="70" height="70">
            </td>
            <td>
                <span id="title">LAPORAN PRESENSI <br>
                    PERIODE {{strtoupper($monthName[$bulan])}} {{$tahun}}<br>
                    UNIVERSITAS UNIVERSAL<br>
                </span>
                <span id="tagalamat">Kelurahan Sadai, Kecamatan Bengkong, Kota Batam, Kepulauan Riau 29432</span>
            </td>
        </tr>
    </table>

    <table class="tablekaryawan">
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{$karyawan->nik}}</td>
        </tr>
        <tr>
            <td>Nama Karyawan</td>
            <td>:</td>
            <td>{{$karyawan->nama_lengkap}}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{$karyawan->jabatan}}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>:</td>
            <td>{{$karyawan->nama_dept}}</td>
        </tr>
    </table>

    <table class="tablepresensi">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Keterangan</th>
                <th>Jumlah Jam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presensi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date("d-m-Y", strtotime($item->tgl_presensi)) }}</td>
                <td>{{ $item->jam_in != null ? $item->jam_in : 'Belum absen' }}</td>
                <td>{{ $item->jam_out != null ? $item->jam_out : 'Belum absen' }}</td>
                <td>
                    @if($item->jam_in > $item->jam_masuk) 
                    @php
                        $jam_terlambat = selisih($item->jam_masuk, $item->jam_in);
                    @endphp Terlambat {{$jam_terlambat}}
                    @else Tepat Waktu
                    @endif
                </td>
                <td>
                    @if ($item->jam_out != null)
                        @php
                            $jamkerja = selisih($item->jam_in, $item->jam_out);
                        @endphp
                    @else
                       @php  $jamkerja = 0; @endphp
                    @endif
                    {{$jamkerja}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table width="100%" style="margin-top: 100px;">
        <tr>
            <td style="text-align: center; vertical-align:bottom;" height="100px">
                <u>Nama HRD</u><br>
                <i><b>HRD Manager</b></i>
            </td>
            <td style="text-align: center; vertical-align:bottom;">
                <u>Nama Direktur</u><br>
                <i><b>Direktur Kepegawaian</b></i>
            </td>
        </tr>
    </table>

  </section>

</body>

</html>