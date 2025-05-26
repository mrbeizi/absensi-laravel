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
        font-size: 10px;
    }
    .tablepresensi tr td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 10px;
        text-align: center;
    }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">
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
            <th colspan="31">Tanggal</th>
            <th rowspan="2">TH</th>
            <th rowspan="2">TT</th>
        </tr>
        <tr>
            <?php 
                for($i=1; $i<=31; $i++){
            ?>
                <th>{{$i}}</th>
            <?php
                }
            ?>
        </tr>
        @foreach($rekap as $item)
        <tr>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <?php 
                $totalhadir = 0;
                $totalterlambat = 0;
                for($i=1; $i<=31; $i++){
                    $tgl = "tgl_".$i;
                    if(empty($item->$tgl)){
                        $hadir = ['',''];
                        $totalhadir += 0;
                    } else {
                        $hadir = explode("-", $item->$tgl);
                        $totalhadir += 1;
                        if($hadir[0] > "07:00:00") {
                            $totalterlambat += 1;
                        }
                    }
            ?>
                <td>
                    <span style="color:{{ $hadir[0] > "07:00:00" ? 'red' : '' }}">{{ $hadir[0] }}</span><br>
                    <span style="color:{{ $hadir[1] < "16:00:00" ? 'red' : '' }}">{{ $hadir[1] }}</span>
                </td>                
            <?php
                }
            ?>
            <td>{{ $totalhadir }}</td>
            <td>{{ $totalterlambat }}</td>
        </tr>
        @endforeach
    </table>

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