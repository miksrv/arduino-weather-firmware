<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    \Core\Router::instance()->registration('/', 'main.php', 'Main', 'make');
    \Core\Router::instance()->registration('insert', 'main.php', 'Insert', 'write');
    \Core\Router::instance()->registration('statistics', 'statistics.php', 'Statistics', 'make');

/* Location: /php.inc/config/routes.php */