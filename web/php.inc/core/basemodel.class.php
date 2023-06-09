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
 * The base model is extensible class, which inherits any custom classes
 * 
 * @package Automated weather station
 * @subpackage Core
 * @category BaseModel
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.0 (25.08.2016)
 */
class BaseModel {

    /**
     * CLASS CONSTRUCTOR
     */
    function __construct($object) {
        $this->delegate($object);
    }

    /**
     * Extends super global '$this' object by adding variables in the section JSON
     * 
     * @access protected
     * @param object $object
     * @return void
     */
    protected function delegate($object) {
        if ( ( ! is_object($object) && ! is_array($object)) || is_null($object))
            return array();

        $variables = get_object_vars($object);

        foreach ($variables as $key => $val) {
            $this->$key = $val;
        }
    } // protected function delegate($object)
}

/* Location: /php.inc/core/basemodel.class.php */