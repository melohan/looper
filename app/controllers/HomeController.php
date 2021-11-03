<?php

namespace App\Controllers;

class HomeController extends Controller
{
    function index()
    {
       return $this->view('page.index');
    }

}