<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

if ( ! function_exists('get_season')) {
    /**
     * Returns the name of the current season
     * @return string
     */
    function get_season() {
        $season = array('winter', 'spring', 'summer', 'autumn');
        $month  = date('m');

        if ($month == 12 || $month == 1 || $month == 2 ) {

            return $season[0];
        } else if ($month >= 3 && $month <= 5) {

            return $season[1];
        } else if ($month >= 6 && $month <= 8) {

            return $season[2];
        } else if ($month >= 9 && $month <= 11) {

            return $season[3];
        }

        return NULL;
    } // function get_season()
}

if ( ! function_exists('get_times_of_day')) {
    /**
     * Returns the name of the current time of day
     * @return string
     */
    function get_times_of_day() {
        $times = array('sunrise', 'day', 'sunset', 'night');
        $hours = date('H');

        if ($hours >= 6 && $hours <= 11) {

            return $times[0];
        } else if ($hours >= 12 && $hours <= 17) {

            return $times[1];
        } else if ($hours >= 18 && $hours <= 22) {

            return $times[2];
        } else if ($hours >= 22 && $hours <= 5) {

            return $times[3];
        }

        return NULL;
    } // function get_times_of_day()
}

if ( ! function_exists('format_date')) {
    /**
     * Formats a date and time in a predetermined pattern
     * @param datetime $datetime
     * @return datetime
     */
    function format_date($datetime) {
        $date = new DateTime($datetime);
        
        return $date->format('d.m.Y H:i');
    } // function format_date()
}

if ( ! function_exists('time_elapsed_string')) {
    /**
     * Returns the elapsed time
     * @param datetime $ptime
     * @return string
     */
    function time_elapsed_string($ptime) {
        $date  = new DateTime($ptime);
        $etime = time() - $date->getTimestamp();

        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
                     30 * 24 * 60 * 60  =>  'month',
                          24 * 60 * 60  =>  'day',
                               60 * 60  =>  'hour',
                                    60  =>  'minute',
                                     1  =>  'second'
                    );
        $a_plural = array( 'year'   => 'years',
                           'month'  => 'months',
                           'day'    => 'days',
                           'hour'   => 'hours',
                           'minute' => 'minutes',
                           'second' => 'seconds'
                    );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    } // function time_elapsed_string($ptime)
}

if ( ! function_exists('timestamp_to_time')) {
    /**
     * Formats a date and time in time only
     * @param datetime $timestamp
     * @return datetime
     */
    function timestamp_to_time($timestamp) {
        return date('H:i', $timestamp);
    } // function timestamp_to_time($timestamp)
}

/* Location: /php.inc/helpers/date.php */