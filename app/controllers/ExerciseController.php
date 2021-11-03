<?php

namespace App\Controllers;

use App\Models\Exercise;

class ExerciseController extends Controller
{
    function index()
    {
        return $this->view('exercise.create');
    }

    function take()
    {
        return $this->view('exercise.take');
    }

    function manage()
    {
        return $this->view('exercise.manage');
    }

    function edit()
    {
        return $this->view('exercise.edit');
    }


    function fields()
    {
        return $this->view('exercise.fields');
    }

    function fulfillments()
    {
        return $this->view('exercise.fulfillments');
    }

    function create()
    {
        return $this->view('exercise.fields');
    }

}
