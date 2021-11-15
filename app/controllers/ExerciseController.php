<?php

namespace App\Controllers;

use App\Models\Exercise;

use App\models\ExerciseStatus;
use Exception;

class ExerciseController extends Controller
{
    function index()
    {
        return $this->view('exercise.create');
    }

    function take()
    {
        try {
            $allExercises = Exercise::selectManyWhere('status_id', 2);
            return $this->view('exercise.take', compact('allExercises'));
        } catch (Exception $e) {
            return $this->view('exercise.take');
        }
    }

    function manage()
    {
        $building = Exercise::selectByStatus(ExerciseStatus::BUILDING);
        $answering = Exercise::selectByStatus(ExerciseStatus::ANSWERING);
        $closed = Exercise::selectByStatus(ExerciseStatus::CLOSED);
        return $this->view('exercise.manage', compact('building', 'answering', 'closed'));
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
        try {
            $exercise = new Exercise();
            $name = htmlentities($_POST['exerciseTitle']);
            $exercise->setTitle($name);
            $exercise->getStatus()->setId(2);
            $exercise->create();
            header('Location: /question/fields/' . $exercise->getId());
        } catch (Exception $e) {
            return $this->view(('exercise.create'));
        }
    }
}
