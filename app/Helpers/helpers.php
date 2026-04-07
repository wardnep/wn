<?php

function date2MySqlDate2($date)
{
    if ($date == '')
        return '';

    $dates = explode(' ', $date);

    $months = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

    $day = sprintf('%02d', $dates[0]);
    $month = sprintf('%02d', array_search($dates[1], $months));
    $year = sprintf('%02d', $dates[2]);
    $year = (int) $year - 543;
    $year = (string) $year;
    return $year . '-' . $month . '-' . $day;
}
