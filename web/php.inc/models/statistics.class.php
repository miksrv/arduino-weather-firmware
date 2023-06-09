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
 * @category Statistics
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.2.0 (08.12.2016)
 */
class Statistics extends \Core\BaseModel {

    /**
     * CLASS CONSTRUCTOR
     */
    function __construct() {
        $this->delegate(JSON::get_section('dashboard'));
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
     * Create a json array of data to plot
     * 
     * @param string $set array key name $this->data_sets
     * @param array $data mysql-data
     * @return array
     */
    function make_data_graphs($data) {
        $result  = array();
        $counter = 0;

        $max_v = 0;
        $min_v = 99;

        $prev_value = NULL;

        $temp_value = array(
            'datetime' => 0,
            'battery'  => 0,

            'temp1' => 0,
            'temp2' => 0,
            'humd'  => 0,
            'light' => 0,
            'wind'  => 0,
            'press' => 0,
        );

        foreach ($data as $array) {
            if ($array['battery'] <= 0) {
                continue;
            }
            
            if ($prev_value != NULL && $prev_value != $array['period']) {
                $date = floor($temp_value['datetime'] / $counter);

                $result['datetime'][] = $date;
                $result['battery'][]  = array($date, (float) round($temp_value['battery'] / $counter, 2));

                $result['temp1'][] = array($date, (float) round($temp_value['temp1'] / $counter, 1));
                $result['temp2'][] = array($date, (float) round($temp_value['temp2'] / $counter, 1));
                $result['humd'][]  = array($date, (float) round($temp_value['humd'] / $counter, 1));
                $result['light'][] = array($date, (float) round($temp_value['light'] / $counter, 1));
                $result['wind'][]  = array($date, (float) round($temp_value['wind'] / $counter, 2));
                $result['press'][] = array($date, (float) round($temp_value['press'] / $counter, 1));

                $max_v = round($temp_value['battery'] / $counter, 2) > $max_v ? round($temp_value['battery'] / $counter, 2) : $max_v;
                $min_v = round($temp_value['battery'] / $counter, 2) < $min_v ? round($temp_value['battery'] / $counter, 2) : $min_v;

                $temp_value = array(
                    'datetime' => 0,
                    'battery'  => 0,

                    'temp1' => 0,
                    'temp2' => 0,
                    'humd'  => 0,
                    'light' => 0,
                    'wind'  => 0,
                    'press' => 0,
                );

                $counter = 0;
            }

            $prev_value = $array['period'];

            $date = new \DateTime($array['datestamp']);
            $date = $date->getTimestamp() * 1000; // $date->format('m/d/Y H:i');

            $counter++;

            $temp_value['datetime'] += $date;
            $temp_value['battery']  += $array['battery'];
            
            $temp_value['temp1'] += $array['temp1'];
            $temp_value['temp2'] += $array['temp2'];
            $temp_value['humd']  += $array['humd'];
            $temp_value['light'] += $array['light'];
            $temp_value['wind']  += $array['wind'];
            $temp_value['press'] += $array['press'];
        }
        
        $result['max_v'] = $max_v;
        $result['min_v'] = $min_v;

        return $result;
    } // function make_data_graphs($set, $data)
}

/* Location: /php.inc/models/statistics.class.php */