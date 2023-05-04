<?php
    // Prints: October 3, 1975 was on a Friday
    // $month = 30;
    // $week = 7;
    // $halfyear = 6;
    // $date = date("Y:m:d", mktime(0,0,0,6,2+$month,2018));
    // $date2 = date("Y:M:d", mktime(0,0,0,6,2+$week,2018));
    // $date3 = date("Y:M:d", mktime(0,0,0,6+$halfyear,2,2018));
    // echo $date."<br>";
    // echo $date2."<br>";
    // echo $date3."<br>";
    // $today = date("Y:M:d", mktime(0,1,0,date("m"),date("d")+10,date("Y")));
    // echo $today;
    // echo date("M");
    // $year = date('Y');
    // echo $year;
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $sevenday = date("Y/m/d", mktime(0,0,0,$month,$day-7,$year));
    echo $sevenday.'<br>';
    $onemonth = date("Y/m/d", mktime(0,0,0,$month-1,$day,$year));
    echo $onemonth.'<br>';
    $halfyear = date("Y/m/d", mktime(0,0,0,$month-6,$day,$year));
    echo $halfyear.'<br>';
?>