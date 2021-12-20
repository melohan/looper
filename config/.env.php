<?php

/**
 * This file contains project path constants
 **/

define('PROJECT_ROOT', dirname($_SERVER["DOCUMENT_ROOT"]));
$site_url = str_replace('\\', '/', str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', PROJECT_ROOT));
define('VIEWS', $site_url . DIRECTORY_SEPARATOR . 'resources/views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
