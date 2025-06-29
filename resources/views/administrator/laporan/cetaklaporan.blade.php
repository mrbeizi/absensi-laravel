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
                <th>Status</th>
                <th>Keterangan</th>
                <th>Jumlah Jam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presensi as $item)
                @if($item->status == "h")
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date("d-m-Y", strtotime($item->tgl_presensi)) }}</td>
                        <td>{{ $item->jam_in != null ? $item->jam_in : 'Belum absen' }}</td>
                        <td>{{ $item->jam_out != null ? $item->jam_out : 'Belum absen' }}</td>
                        <td>@php
                            $statusLabels = [
                                'h' => '<span class="badge bg-success">Hadir</span>',
                                's' => '<span class="badge bg-danger">Sakit</span>',
                                'i' => '<span class="badge bg-warning">Izin</span>',
                                'c' => '<span class="badge bg-purple">Cuti</span>'
                            ];
                            @endphp

                            {!! $statusLabels[$item->status] ?? '<span class="badge bg-secondary">Tidak Diketahui</span>' !!}
                        </td>
                        <td>
                            @if($item->jam_in > $item->jam_masuk) 
                            @php
                                $jam_terlambat = countOfficeHours($item->jam_masuk, $item->jam_in);
                            @endphp Terlambat {{$jam_terlambat}}
                            @else Tepat Waktu
                            @endif
                        </td>
                        <td>
                            @if ($item->jam_out != null)
                                @php
                                    $tglMasuk = $item->tgl_presensi;
                                    $tglPul = $item->lintas_hari == '1' ? date('Y-m-d', strtotime("+1 days", strtotime($tglMasuk))) : $tglMasuk;
                                    $jamMasuk = $tglMasuk . "" .$item->jam_in;
                                    $jamPulang = $tglPul . "" .$item->jam_out;
                                    $jamkerja = countOfficeHours($jamMasuk, $jamPulang);
                                @endphp
                            @else
                            @php  $jamkerja = 0; @endphp
                            @endif
                            {{$jamkerja}}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date("d-m-Y", strtotime($item->tgl_presensi)) }}</td>
                        <td>&ndash;</td>
                        <td>&ndash;</td>
                        <td>@php
                            $statusLabels = [
                                'h' => '<span class="badge bg-success">Hadir</span>',
                                's' => '<span class="badge bg-danger">Sakit</span>',
                                'i' => '<span class="badge bg-warning">Izin</span>',
                                'c' => '<span class="badge bg-purple">Cuti</span>'
                            ];
                            @endphp

                            {!! $statusLabels[$item->status] ?? '<span class="badge bg-secondary">Tidak Diketahui</span>' !!}
                        </td>
                        <td>{{ $item->keterangan }}</td>
                        <td></td>
                    </tr>
                @endif
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