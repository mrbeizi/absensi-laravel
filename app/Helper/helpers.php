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