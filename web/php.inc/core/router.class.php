<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    namespace Core;

/**
 * THE ROUTER CLASS
 * 
 * @package Automated weather station
 * @subpackage Core
 * @category Router
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.0 (25.08.2016)
 */
class Router {

    /**
     * The array contains all available routes
     * @var array 
     */
    public $routes = array();
    
    /**
     * Link to this instance of the class
     * @var type 
     */
    private static $instance = NULL;


    /**
     * The method returns an instance of this class
     * 
     * @static
     * @return object this
     */
    static function instance() {
        if (self::$instance == NULL) {
            self::$instance = new \Core\Router();
        }

        return self::$instance;
    } // static function instance()


    /**
     * This method registers a new route
     * 
     * @param type $url route url
     * @param type $template use template in /php.inc/views
     * @param type $controller use controlller in /php.inc/controllers
     * @param type $method use method in controller
     * @return void
     */
    function registration($url, $template, $controller, $method) {
        $this->routes[$url] = array(
            'template'   => $template,
            'controller' => $controller,
            'method'     => $method
        );
    } // function registration($url, $template, $controller, $method)


    /**
     * The method checks the current address, in case of a match with the address 
     * in the route list will take you back an object, otherwise - FALSE.
     * 
     * @param string $url url address
     * @return mixed (object) if match or (boolean) FALSE
     */
    function load($url) {
        if (empty($url))
            $url = '/';

        if (key_exists($url, $this->routes))
            return (object) $this->routes[$url];

        return FALSE;
    } // function load($url)


    /**
     * Method returns the current address of the page
     * 
     * @static
     * @return string
     */
    static function get_uri() {
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

        $uri = preg_replace('|'.dirname($_SERVER['PHP_SELF']).'|i', '', $uri_parts[0]);
        $uri = str_replace("/", "", $uri);

        return $uri;
    } // static function get_uri()


    /**
     * Redirect to another page
     * 
     * @static
     * @param string $url
     */
    static function redirect($url, $code = 303) {
        header('Location: ' . $url, TRUE, $code);
        exit();
    } // static function redirect($url)


    /**
     * Detect an AJAX request
     * 
     * @static
     * @return boolean
     */
    static function is_ajax() {
        if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return TRUE;

        return FALSE;
    } // static function is_ajax()
    
    
    /**
     * Get User-Agent
     * 
     * @static
     * @return string
     */
    static function user_agent() {
        return ( ! isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];
    } // static function user_agent()
    
    
    /**
     * Get IP
     * 
     * @static
     * @return string
     */
    static function user_ip() {
        return $_SERVER['REMOTE_ADDR'];
    } // function ip_address()
}

/* Location: /php.inc/core/router.class.php */