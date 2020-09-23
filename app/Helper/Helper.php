<?php

namespace App\Helper;

class Helper
{

    public static function formatDateTime($sql_datetime){
        // Creating timestamp from given date
        $timestamp = strtotime($sql_datetime);

        // Creating new date format from that timestamp
        $new_date = date("Y-m-d H:m:s", $timestamp);

        return $new_date; // Outputs: 31-03-2019
    }

    public static function formatDate($sql_datetime){
        // Creating timestamp from given date
        $timestamp = strtotime($sql_datetime);

        // Creating new date format from that timestamp
        $new_date = date("Y-m-d", $timestamp);

        return $new_date; // Outputs: 31-03-2019
    }
}
