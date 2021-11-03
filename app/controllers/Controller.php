<?php

namespace App\Controllers;

class Controller
{

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
