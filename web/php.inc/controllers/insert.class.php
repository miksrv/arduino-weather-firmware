<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    namespace Controllers;

/**
 * Custom controller class
 * 
 * @package Automated weather station
 * @subpackage Controllers
 * @category Insert
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.5 (28.10.2016)
 */
class Insert {

    /**
     * Link to the parent object (global object 'this')
     * @var object 
     */
    private $parent;

    /**
     * Loaded config for arduino
     * @var array
     */
    private $arduino;

    /**
     * Get the income weather params;
     * @var array
     */
    private $params;


    /**
     * CLASS CONSTRUCTOR
     */
    function __construct($parent) {    
        $this->parent = $parent;
    } // function __construct($parent)


    /**
     * @return void
     */
    function write() {
        $this->load_arduino_config();

        $this->check_secret();
        $this->get_weather_params();
        $this->save_to_database();
        $this->send_to_narodmon();

        $this->parent->view->json(array('code' => 'success'));
    } // function write()


    /**
     * Loaded the aruino config file
     * 
     * @access protected
     * @see /php.inc/config/arduino.php
     * @return void
     */
    protected function load_arduino_config() {
        require_once COREPATH . 'config/arduino.php';

        $this->arduino = $config;
    } // protected function load_arduino_config()


    /**
     * It compares the secret key from the address bar with a secret key in 
     * the configuration file
     * 
     * @access protected
     * @see /php.inc/config/arduino.php
     * @return void
     */
    protected function check_secret() {
        if ( ! isset($_POST['ID']) || $_POST['ID'] != $this->arduino['secret'])
            \Core\Router::redirect(DIR_ROOT);
    } // protected function check_secret()


    /**
     * Get the necessary parameters from the address bar
     * 
     * @access protected
     * @return void
     */
    protected function get_weather_params() {
        $this->params = array(
            'temp1' => $_POST['t2'] ? (float) $_POST['t2'] : NULL,
            'temp2' => $_POST['t1'] ? (float) $_POST['t1'] : NULL,
            'humd'  => $_POST['h'] ? (float) $_POST['h'] : NULL,
            'press' => $_POST['p'] ? (float) $_POST['p'] : NULL,
            'light' => $_POST['l'] ? (int) $_POST['l'] : NULL,
            'wind'  => $_POST['w'] ? (float) $_POST['w'] : NULL,
            'battery' => $_POST['v'] ? (float) $_POST['v'] : NULL
        );

        $this->params = $this->clear_array($this->params);
    } // protected function get_weather_params()


    /**
     * Storing data in a database
     * 
     * @access protected
     * @return void
     */
    protected function save_to_database() {
        if (empty($this->params) || ! is_array($this->params))
            \Core\Router::redirect(DIR_ROOT);

        $this->parent->mysql->save(
                'data', 
                array('data' => $this->params)
            );
    } // protected function save_to_database()


    /**
     * Sending data to the national monitoring server
     * 
     * @access protected
     * @return void
     */
    protected function send_to_narodmon() {
        if (empty($this->params) || ! is_array($this->params))
            return;

        $post = array(
            'ID' => $this->arduino['mac_address'],
            'T1' => isset($this->params['temp1']) ? $this->params['temp1'] : NULL,
            'T2' => isset($this->params['temp2']) ? $this->params['temp2'] : NULL,
            'H'  => isset($this->params['humd']) ? $this->params['humd'] : NULL,
            'P'  => isset($this->params['press']) ? $this->params['press'] : NULL,
            'L'  => isset($this->params['light']) ? $this->params['light'] : NULL,
            'W'  => isset($this->params['wind']) ? $this->params['wind'] : NULL,
            'V'  => isset($this->params['battery']) ? $this->params['battery'] : NULL
        );

        $narodmon = new \Libraries\Narodmon();

        $narodmon->send($this->clear_array($post));
    } // protected function send_to_narodmon()


    /**
     * The method removes from the array nulls
     * 
     * @param array
     * @return array
     */
    protected function clear_array($data) {
        if ( ! is_array($data) || empty($data)) {
            return array();
        }

        foreach ($data as $key => $val) {
            if (is_null($data[$key])) {
                unset($data[$key]);
            }
        }

        return $data;
    } // protected function clear_array($data)
}

/* Location: /php.inc/controllers/insert.class.php */