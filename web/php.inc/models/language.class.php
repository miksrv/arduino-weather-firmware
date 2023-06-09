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
 * SITE LANGUAGE CLASS
 * 
 * @package Automated weather station
 * @subpackage Models
 * @category Language
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.0 (25.08.2016)
 */
class Language extends \Core\BaseModel {

    /**
     * CLASS CONSTRUCTOR
     */
    function __construct() {
        $this->delegate(JSON::get_section('language'));
    } // function __construct()


    /**
     * Get all the properties of the object JSON-section 'language'
     * 
     * @return \Models\Profile
     */
    function get() {
        return $this;
    }
}

/* Location: /php.inc/models/language.class.php */