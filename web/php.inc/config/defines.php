<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    if (DEBUG) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

    define('VIEWPATH', BASEPATH . 'php.inc/views/');

    define('DIR_LIBRARIES', COREPATH . 'libraries/');
    define('DIR_CONTROLLERS', COREPATH . 'controllers/');
    define('DIR_MODELS', COREPATH . 'models/');
    define('DIR_CORECLASS', COREPATH . 'core/');
    define('DIR_CONTENT', COREPATH . 'data/');

    define('DIR_ROOT', '/');

/* Location: /php.inc/config/defines.php */