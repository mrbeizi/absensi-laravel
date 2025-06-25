<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Rekap Presensi</title>

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
    .tablepresensi {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }
    .tablepresensi tr th {
        border: 1px solid #ddd;
        padding: 8px;
        background-color: azure;
        font-size: 9px;
    }
    .tablepresensi tr td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 9px;
        text-align: center;
    }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">

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
                <span id="title">REKAP PRESENSI <br>
                    PERIODE {{strtoupper($monthName[$bulan])}} {{$tahun}}<br>
                    UNIVERSITAS UNIVERSAL<br>
                </span>
                <span id="tagalamat">Kelurahan Sadai, Kecamatan Bengkong, Kota Batam, Kepulauan Riau 29432</span>
            </td>
        </tr>
    </table>

    <table class="tablepresensi">
        <tr>
            <th rowspan="2">NIK</th>
            <th rowspan="2">Nama Karyawan</th>
            <th colspan="{{$jumlahHari}}">Bulan {{$monthName[$bulan]}} {{$tahun}}</th>
            <th rowspan="2">H</th>
            <th rowspan="2">C</th>
            <th rowspan="2">I</th>
            <th rowspan="2">S</th>
            <th rowspan="2">A</th>
        </tr>
        <tr>
            @foreach ($rangeTanggal as $item)
                @if($item != NULL)
                    <th>{{date("d", strtotime($item))}}</th>
                @endif
            @endforeach
        </tr>
        @foreach($rekap as $res)
        <tr>
            <td>{{ $res->nik }}</td>
            <td>{{ $res->nama_lengkap }}</td>
            @php
                $jHadir = 0;
                $jIzin = 0;
                $jSakit = 0;
                $jCuti = 0;
                $jAbsen = 0;
                $color = "";
                $status = "";
            @endphp
            @for ($i = 1; $i <= $jumlahHari; $i++)
                @php
                    $tgl = "tgl_".$i;
                    $timestamp = mktime(0, 0, 0, $bulan, $i, $tahun);
                    $namaHari = strftime('%A', $timestamp);
                    $tgl_pres = $rangeTanggal[$i-1];
                    $datapresensi = explode("|", $res->{$tgl});
                    $search_items = [
                        'nik' => $res->nik,
                        'tgl_libur' => $tgl_pres
                    ];
                    $checklibur = checkLiburKaryawan($datalibur, $search_items);
                    if($res->{$tgl} != NULL) {
                        $status = $datapresensi[2];
                    } else {
                        $status = "";
                    }

                    if($status == "h"){
                        $jHadir += 1;
                        $color = "white";
                    }
                    if($status == "c"){
                        $jCuti += 1;
                        $color = "yellow";
                    }
                    if($status == "i"){
                        $jIzin += 1;
                        $color = "orange";
                    }
                    if($status == "s"){
                        $jSakit += 1;
                        $color = "blue";
                    }
                    if(empty($status)){
                        $jAbsen += 1;
                        $color = "red";
                    }
                    if(!empty($checklibur)){
                        $jAbsen -= 1;
                        $color = "green";
                    }
                    if($namaHari == "Sunday"){
                        $jAbsen -= 1;
                        $color = "black";
                    }
                @endphp                
                <td style="background-color: {{$color}}">{{$status}}</td>
            @endfor
            <td>{{!empty($jHadir) ? $jHadir : ""}}</td>
            <td>{{!empty($jCuti) ? $jCuti : ""}}</td>
            <td>{{!empty($jIzin) ? $jIzin : ""}}</td>
            <td>{{!empty($jSakit) ? $jSakit : ""}}</td>
            <td>{{!empty($jAbsen) ? $jAbsen : ""}}</td>
            
        </tr>

        @endforeach
    </table>
    <small><p>Keterangan Libur:</p></small>
    <ol>
        @foreach($ketlibur as $ket)
            <small><li>{{date('d-m-Y', strtotime($ket->tgl_libur))}} &ndash; {{$ket->keterangan}}</li></small>
        @endforeach
    </ol>

    <table width="100%" style="margin-top: 100px;">
        <tr>
            <td></td>
            <td style="text-align: center;">Batam, {{date('d-m-Y')}}</td>
        </tr>
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