<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    namespace Core;

	use \Core\View as View;
	use \Core\Router as Router;
        use \Libraries\JSON as JSON;
        use \Libraries\MySQL as MySQL;

/**
 * THE BASE CLASS
 * 
 * @package Automated weather station
 * @subpackage Core
 * @category Main
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.1 (09.12.2016)
 */
class Main {

    /**
     * Reference to the class object 'view'
     * @var object 
     */
    public $view;

    /**
     * Reference to the class object 'mysql'
     * @var object 
     */
    public $mysql;
    
    /**
     * Current language
     * @example 'en'
     * @var string
     */
    public $current_language = NULL;

    /**
     * The array of available language (contents files)
     * @var array 
     */
    public $available_languages = array();

    /**
     * CLASS CONSTRUCTOR
     */
    function __construct() {
        $this->view  = new View();
        $this->mysql = new MySQL();

        $this->initialization();
    } // function __construct()


    /**
     * This method uses the routing class and invokes the appropriate controller
     * 
     * @return void
     */
    function initialization() {
        $url   = Router::instance()->get_uri();
        $route = Router::instance()->load($url);

        $this->_choose_language();
        $this->_load_data();
        $this->navigate($route);
    } // function initialization()


    /**
     * It is the method of the current route controller
     * 
     * @param object $route current route
     * @throws \Exception
     * @return void
     */
    function navigate($route) {

        if (empty($route) || ! is_object($route) || 
            ! isset($route->controller) || ! isset($route->method))

            $this->view->show_error_404();

        $controller = $this->_load_controller($route->controller);

        if ( ! method_exists($controller, $route->method))
            throw new \Exception('Controller ' . $route->controller . ' has no method ' . $route->method);

        call_user_func_array(array($controller, $route->method), array());

        $this->view->display($route->template);
    } // function navigate($route)


    /**
     * It creates a navigation menu
     * 
     * @return string
     */
    function create_lang_menu() {
        if ( ! $this->available_languages)
            return ;

        $result = '';

        foreach ($this->available_languages as $lang) {
            $select  = $this->current_language == $lang ? ' active' : NULL;

            $result .= '<li class="lang' . $select . '"><a href="?lang=' . $lang . '" title="">' . $lang . '</a></li>';
        }

        return $result;
    } // function create_lang_menu()


    /**
     * Loading controller class
     * 
     * @access private
     * @param string $controller controller class name
     * @return \Core\class
     */
    private function _load_controller($controller) {
        $class = "\Controllers\\{$controller}";

        return new $class($this);
    } // private function _load_controller($controller)


    /**
     * Selects the current language of the content
     * 
     * @access private
     * @return void
     */
    private function _choose_language() {
        $this->_get_avaliable_langs();

        $language = new \Libraries\Lang();
        $cookies  = new \Libraries\Cookies();

        /**
         * Intercept language switch
         */
        if (isset($_GET['lang']) && in_array($_GET['lang'], $this->available_languages)) {
            $cookies::set_cookie('language', $_GET['lang']);
            Router::redirect(DIR_ROOT);
        }

        $lang_cookie = $cookies::get_cookie('language');

        if ($lang_cookie && in_array($lang_cookie, $this->available_languages)) {

            $this->current_language = $lang_cookie;

        } else {

            $langs = array(
              'ru' => array('ru', 'be', 'uk', 'ky', 'ab', 'mo', 'et', 'lv'),
            );

            $this->current_language = $language->check_language('en', $langs);
        }
    } // private function choose_language()


    /**
     * Defines the languages available on the basis of the content of files
     * 
     * @access private
     * @return void
     */
    private function _get_avaliable_langs() {
        if ($handle = opendir(DIR_CONTENT)) {

            while (false !== ($file = readdir($handle))) {

                if ($file != "." && $file != "..") {

                    $filename = explode('.', $file);
                    $this->available_languages[] = $filename[0];
                } 
            }

            closedir($handle); 
        }
    } /// private function _get_avaliable_langs()


    /**
     * Loading JSON-format content data file
     *
     * @access private
     * @throws \Exception
     * @return void
     */
    private function _load_data() {
        $filename = $this->current_language . '.content.json';

        if ( ! file_exists(DIR_CONTENT . $filename))
            throw new \Exception('Not exists a content data file (' . $filename . ')');

        $content = file_get_contents(DIR_CONTENT . $filename);

        JSON::set_data($content);
    } // private function _load_data()
}

/* Location: /php.inc/core/main.class.php */