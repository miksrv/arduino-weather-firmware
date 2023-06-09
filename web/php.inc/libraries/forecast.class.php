<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    namespace Libraries;

/**
 * Language class
 * 
 * @package Automated weather station
 * @subpackage Libraries
 * @category Forecast
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.0 (20.10.2016)
 */
class Forecast {

    /**
     * Upper limit of the 'weather window' (1050.0 hPa UK)
     * @var float
     */
    var $pressure_max = 1050;

    /**
     * Lower limit 'weather window' (950.0 hPa UK)
     * @var float
     */
    var $pressure_min = 950;

    /**
     * Hemisphere (North = 1, South = 2)
     * @var integer
     */
    var $hemisphere = 1;


    /**
     * It returns the index of an array of language with the weather forecast for the near future
     * 
     * @param float $pressure_now
     * @param float $pressure_prev
     * @param float $wind
     * @return int
     */
    function forecast($pressure_now, $pressure_prev, $wind = FALSE) {
        $pressure = $pressure_now < $this->pressure_min ? $this->convert_mm_to_hpa($pressure_now) : $pressure_now;

        $trend = $this->_calculate_trend($pressure, $pressure_prev);

        $options_rise   = Array(25,25,25,24,24,19,16,12,11,9,8,6,5,2,1,1,0,0,0,0,0,0);
        $options_steady = Array(25,25,25,25,25,25,23,23,22,18,15,13,10,4,1,1,0,0,0,0,0,0);
        $options_fall   = Array(25,25,25,25,25,25,25,25,23,23,21,20,17,14,7,3,1,1,1,0,0,0);

        $range    = $this->pressure_max - $this->pressure_min;
        $constant = round(($range / 22), 3);
        $season   = ((date('n') >= 4) && (date('n') <= 9));

        if ($this->hemisphere == 1) {
            switch ($wind) {
                case 'N'   : $pressure += 6 / 100 * $range; break;
                case 'NNE' : $pressure += 5 / 100 * $range; break;
                case 'NE'  : $pressure += 5 / 100 * $range; break;
                case 'E'   : $pressure -= 0.5 / 100 * $range; break;
                case 'ESE' : $pressure -= 2 / 100 * $range; break;
                case 'SSE' : $pressure -= 8.5 / 100 * $range; break;
                case 'S'   : $pressure -= 12 / 100 * $range; break;
                case 'SW'  : $pressure -= 6 / 100 * $range; break;
                case 'WSW' : $pressure -= 4.5 / 100 * $range; break;
                case 'W'   : $pressure -= 3 / 100 * $range; break;
                case 'NW'  : $pressure += 1.5 / 100 * $range; break;
                case 'NNW' : $pressure += 3 / 100 * $range; break;
            }

            if ($season == TRUE) {
                switch ($trend) {
                    case 1 : $pressure += 7 / 100 * $range; break;
                    case 2 : $pressure -= 7 / 100 * $range; break;
                }
            }

        } else {
            switch ($wind) {
                case 'S'   : $pressure += 6 / 100 * $range; break;
                case 'SSW' : $pressure += 5 / 100 * $range; break;
                case 'SW'  : $pressure += 5 / 100 * $range; break;
                case 'WSW' : $pressure += 2 / 100 * $range; break;
                case 'W'   : $pressure -= 0.5 / 100 * $range; break;
                case 'NW'  : $pressure -= 5 / 100 * $range; break;
                case 'NNW' : $pressure -= 8.5 / 100 * $range; break;
                case 'N'   : $pressure -= 12 / 100 * $range; break;
                case 'NNE' : $pressure -= 10 / 100 * $range; break;
                case 'NE'  : $pressure -= 6 / 100 * $range; break;
                case 'E'   : $pressure -= 3 / 100 * $range; break;
                case 'ESE' : $pressure -= 0.5 / 100 * $range; break;
                case 'SE'  : $pressure += 1.5 / 100 * $range; break;
                case 'SSE' : $pressure += 3 / 100 * $range; break;
            }

            if ($season == FALSE) {
                switch ($trend) {
                    case 1 : $pressure += 7 / 100 * $range; break;
                    case 2 : $pressure -= 7 / 100 * $range; break;
                }
            }
        }

        if ($pressure == $this->pressure_max) {
            $pressure = $this->pressure_max - 1;
        }

        $option = floor(($pressure - $this->pressure_min) / $constant);

        if ($option < 0) {
            $option = 0;
        } else if ($option > 21) {
            $option = 21;
        }

        if ($trend == 1) {
            $result = $options_rise[$option];
        } else if ($trend == 2) {
            $result = $options_fall[$option];
        } else {
            $result = $options_steady[$option];
        }

        return $result;
    } // function forecast($pressure_now, $pressure_prev, $wind)


    /**
     * Converts mmHg in hPa
     * 
     * @param float $pressure
     * @return float
     */
    function convert_mm_to_hpa($pressure) {
        return $pressure * 1.33322;
    } // function convert_mm_to_hpa($pressure)


    /**
     * Calculates pressure change trend: 1 - growth, 2 - decrease, 0 - no change
     * 
     * @param float $pressure_now
     * @param float $pressure_prev
     * @return int
     */
    protected function _calculate_trend($pressure_now, $pressure_prev) {
        if ($pressure_prev < $this->pressure_min) {
            $pressure_prev = $this->convert_mm_to_hpa($pressure_prev);
        }

        if ($pressure_now > $pressure_prev + 0.25) {

            return 1;

        } else if ($pressure_now + 0.25 < $pressure_prev) {

            return 2;
        }

        return 0;
    } // protected function _calculate_trend($pressure_now, $pressure_prev)
}

/* Location: /php.inc/libraries/forecast.class.php */