<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 21:06:44
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 01:10:04
 */

ini_set('display_errors','on');
error_reporting(E_ALL);

define('BASE', realpath('./'));

define('DEBUG', false);

define('DS', DIRECTORY_SEPARATOR);

require BASE . DS . 'core' . DS . 'base.php';

\core\Core::run();



