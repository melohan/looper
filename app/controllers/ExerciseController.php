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
        $allExercises = Exercise::selectAll();
        return $this->view('exercise.take', compact('allExercises'));
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
        $exercise = new Exercise();
        $name = htmlentities($_POST['exerciseTitle']);
        $exercise->setTitle($name);
        $exercise->getStatus()->setId(1);
        $exercise->create();
        header('Location: /exercise/fields/' . $exercise->getId());
    }
}
