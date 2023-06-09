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
 * Information output section all sensors
 * 
 * @package Automated weather station
 * @subpackage Models
 * @category Dashboard
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.2.0 (09.12.2016)
 */
class Dashboard extends \Core\BaseModel {

    /**
     * The loaded mysql data
     */
    public $data = array();
    
    /**
     * Moon class object
     */
    private $moon;

    /**
     * CLASS CONSTRUCTOR
     */
    function __construct($data) {
        $this->delegate(JSON::get_section('dashboard'));

        $moon = new \Libraries\Moon();

        $this->moon = $moon::calculateMoonTimes(
                date("m"), date("d"), date("Y"), 
                $data['arduino']['latitude'], 
                $data['arduino']['longitude']
            );

        $this->data = $data;
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
     * @return string
     */
    function get_moon_rise() {
        return timestamp_to_time($this->moon->moonrise);
    } // function get_moon_rise()

    
    /**
     * @return string
     */
    function get_moon_set() {
        return timestamp_to_time($this->moon->moonset);
    } // function get_moon_set()


    /**
     * @return string
     */
    function get_sun_rise() {
        return date_sunrise(
                time(), 
                SUNFUNCS_RET_STRING, 
                $this->data['arduino']['latitude'], 
                $this->data['arduino']['longitude'], 
                90, 
                $this->data['arduino']['gmt_offset']
            );
    } // function get_sun_rise()


    /**
     * @return string
     */
    function get_sun_set() {
        return date_sunset(
                time(), 
                SUNFUNCS_RET_STRING, 
                $this->data['arduino']['latitude'], 
                $this->data['arduino']['longitude'], 
                90, 
                $this->data['arduino']['gmt_offset']
            );
    } // function get_sun_set()


    /**
     * Computes and returns the dew-point temperature using the current temperature and humidity values
     * 
     * @return float
     */
    function calc_dewpoint() {
        if (empty($this->data['temp1']) || empty($this->data['humd']))
            return NULL;

        return round(((pow(($this->data['humd']/100), 0.125))*(112+0.9*$this->data['temp1'])+(0.1*$this->data['temp1'])-112),1);
    } // function calc_dewpoint()


    /**
     * Calculate the average value of the sensor for a given period 
     * (determined by the number of nested arrays)
     * 
     * @param array $data
     * @return array
     */
    function get_average_value($data) {
        $new   = array();
        $count = count($data);

        if ($count > 0) {
            foreach ($data as $array) {

                foreach ($array as $key => $val) {
                    if ( ! isset($new[$key]))
                        $new[$key] = 0;

                    $new[$key] += $val;
                }
            }
        }

        foreach ($new as $key => $val) {
            $new[$key] = round($new[$key] / $count, 1);
        }

        return $new;
    } // function _get_average_value($data)
    

    /**
     * Depending on the deviation of the mean from the current symbol set of 
     * parameters increase or decrease (FonrtAwesome)
     * 
     * @param array $data
     * @return array
     */
    function get_values_signs($data) {
        $comparison = array('temp1', 'temp2', 'humd', 'press', 'light', 'wind', 'battery');
        $signs      = array();

        foreach ($comparison as $key) {
            if ( ! isset($data[$key]))
                continue;

            if (isset($data['average'][$key]) && $data['average'][$key] > $data[$key])
                $signs[$key] = '<i class="fa fa-long-arrow-down"></i>';

            else if (isset($data['average'][$key]) && $data['average'][$key] < $data[$key])
                $signs[$key] = '<i class="fa fa-long-arrow-up"></i>';
            
            else
                $signs[$key] = '';
        }

        return $signs;
    } // function get_values_signs($data)
}

/* Location: /php.inc/models/dashboard.class.php */