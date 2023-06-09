<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    namespace Models;

        use \Libraries\JSON as JSON;

/**
 * Basic information output section
 * 
 * @package Automated weather station
 * @subpackage Models
 * @category Summary
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.2.1 (12.12.2016)
 */
class Summary extends \Core\BaseModel {

    /**
     * The loaded mysql data
     */
    private $data = array();

    /**
     * CLASS CONSTRUCTOR
     */
    function __construct($data) {
        $this->delegate(JSON::get_section('summary'));

        $this->data = $data;

        $this->now_temp = isset($data['temp1']) ? $data['temp1'] : NULL;
        $this->max_temp = isset($data['max_temp1']) ? $data['max_temp1'] : NULL;
        $this->min_temp = isset($data['min_temp1']) ? $data['min_temp1'] : NULL;
    } // function __construct()


    /**
     * Get all the properties of the object JSON-section 'profile'
     * 
     * @return \Models\Profile
     */
    function get() {
        return $this;
    } // function get()

    
    /**
     * Returns the icon font class for the current phase of the moon
     * 
     * @return string
     * @see \Libraries\MoonPhase\phase_name_class()
     */
    function get_moon_phase_name() {
        $moon  = new \Libraries\MoonPhase();

        return $moon->phase_name_class();
    } // function get_moon_phase_name()
    
    
    /**
     * Returns the file name for the background image, given the current time of year and time of day
     * 
     * @return string
     */
    function get_background_img() {
        $name  = get_season() . '-';
        $name .= get_times_of_day();
        
        return $name . '.jpg';
    } // function get_background_img()

    
    /**
     * Returns index WCT
     * 
     * @param float $wct index WCT
     * @return string
     */
    function get_wct_index($wct) {
        if ($wct > 0) {
            return 0;
        } else if ($wct > -10 && $wct <= 0) {
            return 1;
        } else if ($wct > -28 && $wct <= 10) {
            return 2;
        } else if ($wct > -40 && $wct <= 28) {
            return 3;
        } else if ($wct > -48 && $wct <= 40) {
            return 4;
        } else if ($wct > -55 && $wct <= 48) {
            return 5;
        } else if ($wct < -55) {
            return 6;
        }
    } // function get_wct_index


    /**
     * Returns the color of a string in hexadecimal format on the basis of the index WCT
     * 
     * @param integer $index index WCT
     * @return string
     */
    function get_wct_color($index) {
        $background = array('#FFF', '#B2A9D5', '#C33CBD', '#CC7118', '#C61C1C', '#3F001A');
        $font_color = array('#555', '#FFF', '#FFF', '#FFF', '#FFF', '#FFF');

        return "background-color: {$background[$index]}; color: {$background[$font_color]}";
    } // function get_wct_color


    /**
     * It calculates the WCT on the basis of outdoor temperature and humidity
     * 
     * @return float
     */
    function calc_wct() {
        $wind = 0;
        $temp = 0;
        
        if (isset($this->data['average']) && is_array($this->data['average'])) {
            foreach ($this->data['average'] as $value) {
                $temp += $value['temp1'];
                $wind += $value['wind'];
            }

            $temp = round($temp / count($this->data['average']), 1);
            $wind = round($wind / count($this->data['average']), 1);
        } else {
            $temp = $this->data['temp1'];
            $wind = $this->data['wind'];
        }

        if ($wind == 0)
            return $temp;

        $speed_kmh = ($wind / 1000) * 3600;

        return round((13.12 + 0.6215 * $temp - 11.37 * pow($speed_kmh, 0.16) + 0.3965 * $temp * pow($speed_kmh, 0.16)), 1);
    } // function calc_wct()


    /**
     * @return string
     */
    function forecast() {
        $library = new \Libraries\Forecast();

        return $library->forecast($this->data['press'], $this->data['prev_pressure']);
    } // function forecast()
}

/* Location: /php.inc/models/summary.class.php */