<?php

namespace App\Controllers;

use App\Models\Exercise;

use Exception;

class ExerciseController extends Controller
{
    function index()
    {
        return $this->view('exercise.create');
    }

    function take()
    {
        try{            
            $allExercises = Exercise::selectAll();       
            return $this->view('exercise.take', compact('allExercises'));
        }catch(Exception $e){   
            return $this->view('exercise.take');
        }
    }

    function manage()
    {
        return $this->view('exercise.manage');
    }

    function edit()
    {
        return $this->view('exercise.edit');
    }

    function fulfillments()
    {
        return $this->view('exercise.fulfillments');
    }

    function create()
    {
        try{
            $exercise = new Exercise();
            $name = htmlentities($_POST['exerciseTitle']);
            $exercise->setTitle($name);
            $exercise->getStatus()->setId(1);
            $exercise->create();
            header('Location: /question/fields/' . $exercise->getId());  
        }catch(Exception $e){   
            return $this->view(('exercise.create'));
        }
    }
}
