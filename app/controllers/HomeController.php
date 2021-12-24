<?php

namespace App\Controllers;

class HomeController extends Controller
{
    /**
     * Return home page
     */
    function index()
    {
        return $this->view('page.index');
    }

    /**
     * Return error page according to the error code
     * TODO Make a single view by returning the error code variable
     * @param int $code
     */
    function error(int $code)
    {
        return $code === 500 ? $this->view('page.error500') : $this->view('page.error404');
    }

}