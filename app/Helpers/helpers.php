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

function date2DateThai($date = '')
{
    if ($date == '') {
        //
        //
        //
        // default today date
        return '';
    }
    //
    //
    //
    // convert to date_thai
    // any format
    $day = 0;
    $month = 0;
    $year = 0;

    if (mysqlDateFormat($date)) {
        $date = explode('-', $date);

        $day = (int) $date[2];
        $month = (int) $date[1];
        $year = (int) $date[0] + 543;
    } else if (datePickerFormat($date)) {
        $date = explode('/', $date);

        $day = (int) $date[0];
        $month = (int) $date[1];
        $year = (int) $date[2];
    } else {
        return '';
    }

    $months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

    return $day . ' ' . $months[(int)$month - 1] . ' ' . $year;
}
