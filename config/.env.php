<?php
/**
 * This file contains project path constants
 **/

define('PROJECT_ROOT', dirname($_SERVER["DOCUMENT_ROOT"]));
define('VIEWS', sprintf("%s/resources/views/", PROJECT_ROOT));
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);