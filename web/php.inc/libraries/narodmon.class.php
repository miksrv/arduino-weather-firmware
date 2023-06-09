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
 * @category Narodmon
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.1 (20.10.2016)
 */
class Narodmon  {

    /**
     * URL address of the server
     * @var string 
     */
    protected $url = 'http://narodmon.ru/post';


    /**
     * Sending data
     * 
     * @param array $data
     * @return string
     */
    function send($data) {
        return $this->_curl($this->url, $data);
    }


    /**
     * Sending through CURL
     * 
     * @param string $url
     * @param array $post
     * @return string
     */
    protected function _curl($url, $post = NULL) {
        if (empty($url))
            return FALSE;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        // Если массив $post не пустой, то CURL отправляет методом POST
        if ( ! empty($post)) {
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post)); 
        }

        $out = curl_exec($curl);
        curl_close($curl);

        return $out;
    } // private function _curl($url, $post = array())
    
}

/* Location: /php.inc/libraries/narodmon.class.php */