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
 * @category Statistics
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.2.0 (08.12.2016)
 */
class Statistics {

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
     * CLASS CONSTRUCTOR
     */
    function __construct($parent) {    
        $this->parent = $parent;
    } // function __construct($parent)


    /**
     * @return void
     */
    function make() {
        $this->create_lang_menu();

        $this->load_language();
        $this->load_param_set();

        if (isset($_GET['data'])) {

            $this->parent->view->json($this->load_database());

        }
    } // function write()


    protected function load_param_set() {
        $var = filter_input(INPUT_GET, 'set', FILTER_SANITIZE_ENCODED);

        if ( ! empty($var)) {

            $this->parent->view->assign('set', $var);

        }
    } // protected function load_param_set()


    protected function create_lang_menu() {
        $this->parent->view->assign('lang_menu', $this->parent->create_lang_menu());
    } // protected function create_lang_menu()


    protected function load_language() {        
        $this->langugae = new \Models\Language();

        $this->parent->view->assign('language', $this->langugae->get());
    } // protected function load_language()


    protected function load_database() {
        $section = new \Models\Statistics();
        $period  = $this->get_period();

        $param['sql'] = "SELECT *, DATE_FORMAT(`datestamp`, '%{$period['period']}') AS period "
                      . "FROM data WHERE `datestamp` >= DATE_SUB(NOW(), INTERVAL {$period['interval']}) "
                      . "ORDER BY `datestamp` DESC";

        $data = $this->parent->mysql->get_data('data', $param);

        return $section->make_data_graphs($data);
    } // protected function load_database()


    protected function get_period() {
        $period = filter_input(INPUT_GET, 'period', FILTER_SANITIZE_ENCODED);
        $result = array(
            'period'   => 'i',
            'interval' => '1 DAY'
        );

        switch ($period) {
            case 'week':
                return $result = array(
                    'period'   => 'H',
                    'interval' => '1 WEEK'
                );
            case 'month':
                return $result = array(
                    'period'   => 'd',
                    'interval' => '1 MONTH'
                );
            case 'day' :
            default    :
                return $result;
        }
    } // protected function get_period()
}

/* Location: /php.inc/controllers/statistics.class.php */