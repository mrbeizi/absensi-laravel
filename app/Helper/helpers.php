<?php

    function selisih($jam_in, $jam_out) {
        $j1 = strtotime($jam_in);
        $j2 = strtotime($jam_out);
        $diffTerlambat = $j2 - $j1;
        $jamTerlambat = floor($diffTerlambat / (60*60));
        $menitTerlambat = floor(($diffTerlambat - ($jamTerlambat * (60*60))) / 60);

        $hterlambat = $jamTerlambat <= 9 ? "0" . $jamTerlambat : $jamTerlambat;
        $mterlambat = $menitTerlambat <= 9 ? "0" . $menitTerlambat : $menitTerlambat;

        $terlambat = $hterlambat . ":" . $mterlambat;
        return $terlambat;
    }

    function countDay($start, $end) {
        $start_date = date_create($start);
        $end_date = date_create($end);
        $diff = date_diff($start_date, $end_date);

        return $diff->days + 1;
    }

    function izinCodeGen($nomor_terakhir, $kunci, $jumlah_karakter = 0)
    {
        /* mencari nomor baru dengan memecah nomor terakhir dan menambahkan 1
        string nomor baru dibawah ini harus dengan format XXX000000
        untuk penggunaan dalam format lain anda harus menyesuaikan sendiri */
        $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
        //    menambahkan nol didepan nomor baru sesuai panjang jumlah karakter
        $nomor_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
        //    menyusun kunci dan nomor baru
        $kode = $kunci . $nomor_baru_plus_nol;
        return $kode;
    }

    function countOfficeHours($jam_in, $jam_out)
    {
        $j1 = strtotime($jam_in);
        $j2 = strtotime($jam_out);
        $diff = $j2 - $j1;
        if (empty($j2)) {
            $jam = 0;
            $menit = 0;
        } else {
            $jam = floor($diff / (60 * 60));
            $m = $diff - $jam * (60 * 60);
            $menit = floor($m / 60);
        }
    
        return $jam ."h ". $menit ."m";
    }

    function getHariLiburKaryawan($dari, $sampai)
    {
        $datas = DB::table('hari_libur_details')->join('hari_liburs','hari_liburs.kode_libur','=','hari_libur_details.kode_libur')
            ->whereBetween('tgl_libur',[$dari, $sampai])
            ->get();
        $karyawanlibur = [];
        foreach($datas as $item){
            $karyawanlibur[] = [
                'nik' => $item->nik,
                'tgl_libur' => $item->tgl_libur
            ];
        }
        return $karyawanlibur;
    }

    function checkLiburKaryawan($array, $search_list)
    {
        $result = array();
        foreach($array as $key => $value){
            foreach($search_list as $k => $v){
                if(!isset($value[$k]) || $value[$k] != $v) {
                    continue 2;
                }
            }
            $result[] = $value;
        }
        return $result;
    }