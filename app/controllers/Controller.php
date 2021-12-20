<?php

namespace App\Controllers;

/**
 * Parent controller of all controllers.
 */
class Controller
{
    /**
     * Retrieves the appropriate view based on the given parameter.
     * Variables are passed to the view by parameters.
     * @param $path
     * @param array|null $params
     */
    function view($path, array $params = null)
    {
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require VIEWS . $path . '.php';
        ($params) ? $params = extract($params) : null;
        $content = ob_get_clean();
        require VIEWS . 'layout.php';
    }
}
