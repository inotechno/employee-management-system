<?php

namespace App\Helpers;

use DateInterval;
use DatePeriod;
use DateTime;

class SelisihHariCuti
{
    public static function get($start_date, $end_date)
    {
        $total_hari = 0;
        $array = json_decode(file_get_contents("https://api-harilibur.vercel.app/api"), true);

        $periods = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($end_date))))
        );

        foreach ($periods as $period) {
            $date = $period->format('Y-m-d');
            // $array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);
            // $check = array_search($date, array_column($array, "holiday_date"));

            $is_holiday = false;
            foreach ($array as $holiday) {
                $apiDate = date('Y-m-d', strtotime($holiday['holiday_date']));

                if ($apiDate === $date) {
                    $is_holiday = true;
                    break;
                }
            }

            if ($is_holiday || date("D", strtotime($date)) === "Sun" || date("D", strtotime($date)) === "Sat") {
                // If it's a holiday, Sunday, or Saturday, skip
                continue;
            } else {
                // Otherwise, count as a leave day
                $total_hari++;
            }

            // if ($check !== false) {
            //     //jika tanggal merah berdasarkan libur nasional
            // } else if (date("D", strtotime($date)) === "Sun") {
            //     //jika Hari Minggu
            // } else if (date("D", strtotime($date)) === "Sat") {
            //     //jika Hari Sabtu
            // } else {
            //     //jika Bukan Tanggal Merah dan Libur Nasional
            //     $total_hari++;
            // }
        }

        return $total_hari;
    }
}
