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
 * @category Main
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.2.0 (09.12.2016)
 */
class Main {

    /**
     * Link to the parent object (global object 'this')
     * @var object 
     */
    private $parent;

    /**
     * Link to the langugae section (global object 'this')
     * @var object 
     */
    private $langugae;

    /**
     * The loaded values in the database
     * @var array
     */
    private $data = array();
    
    /**
     * CLASS CONSTRUCTOR
     */
    function __construct($parent) {    
        $this->parent = $parent;
    } // function __construct($parent)


    /**
     * This method creates the main page CV
     * 
     * @return void
     */
    function make() {
        $this->create_lang_menu();

        $this->load_language();
        $this->load_database();
        $this->load_arduino_config();
        $this->load_date_helper();

        $this->load_summary();
        $this->load_dashboard();
    } // function make()


    protected function create_lang_menu() {
        $this->parent->view->assign('lang_menu', $this->parent->create_lang_menu());
    } // protected function create_lang_menu()


    protected function load_language() {
        $this->langugae = new \Models\Language();

        $this->parent->view->assign('language', $this->langugae->get());
    } // protected function load_language()


    protected function load_database() {
        $param['sql'] = "SELECT CURRENT.*, MAX.max_temp1, MIN.min_temp1, PRESS.prev_pressure FROM "
                      . "(SELECT * FROM data ORDER BY `datestamp` DESC LIMIT 1) CURRENT, "
                      . "(SELECT press AS `prev_pressure` FROM data WHERE `datestamp` >= DATE_SUB(NOW(), INTERVAL 1 WEEK) LIMIT 1) PRESS, "
                      . "(SELECT MAX(temp1) AS `max_temp1` FROM data WHERE DATE_FORMAT(`datestamp`, '%Y-%m-%d') = CURDATE() LIMIT 1) MAX, "
                      . "(SELECT MIN(temp1) AS `min_temp1` FROM data WHERE DATE_FORMAT(`datestamp`, '%Y-%m-%d') = CURDATE() LIMIT 1) MIN";

        $this->data   = $this->parent->mysql->get_data('data', $param, TRUE);

        $param['sql'] = "SELECT temp1, temp2, humd, press, light, wind, battery FROM data WHERE `datestamp` >= DATE_SUB(NOW(), INTERVAL 40 MINUTE) ORDER BY `datestamp` DESC";

        $this->data['average'] = $this->parent->mysql->get_data('data', $param);
    } // protected function load_database()


    protected function load_arduino_config() {
        require_once COREPATH . 'config/arduino.php';

        $this->data['arduino'] = $config;
    } // protected function load_arduino_config()


    protected function load_date_helper() {
        include_once COREPATH . 'helpers/date.php';
    } // protected function load_date_helper()


    /**
     * Load sections of the JSON object in the template
     */

    protected function load_summary() {
        $section = new \Models\Summary($this->data);

        $section->time_update  = format_date($this->data['datestamp']);
        $section->time_elapsed = time_elapsed_string($this->data['datestamp']);

        $section->background = $section->get_background_img();
        $section->moon_phase = $section->get_moon_phase_name();

        $section->forecast  = $section->forecast();

        $section->wct_temp  = $section->calc_wct();
        $section->wct_index = $section->get_wct_index($section->wct_temp);
        $section->wct_style = $section->get_wct_color($section->wct_index);

        $this->parent->view->assign('summary', $section->get());
    } // protected function load_summary()


    protected function load_dashboard() {
        $section = new \Models\Dashboard($this->data);

        $section->data['moonrise'] = $section->get_moon_rise();
        $section->data['moonset']  = $section->get_moon_set();
        $section->data['sunrise']  = $section->get_sun_rise();
        $section->data['sunset']   = $section->get_sun_set();

        $section->data['dewpoint'] = $section->calc_dewpoint();
        
        $section->data['average'] = $section->get_average_value($this->data['average']);
        $section->data['signs']   = $section->get_values_signs($section->data);

        unset($section->data['average']);
        
        $this->parent->view->assign('dashboard', $section->get());
    } // protected function load_dashboard()
}

/* Location: /php.inc/controllers/main.class.php */