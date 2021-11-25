<?php

namespace App\Controllers;

use App\Models\Exercise;

use App\models\ExerciseStatus;
use App\Models\Status;
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
            $exercise->getStatus()->setId(ExerciseStatus::ANSWERING);
            $exercise->create();
            header('Location: /question/fields/' . $exercise->getId());
        } catch (Exception $e) {
            return $this->view(('exercise.create'));
        }
    }
    function update()
    {
        try {
            if (isset($_POST['id']) && isset($_POST['status'])) {
                $id = intval($_POST['id']);
                $status = new Status();
                $exercise = new Exercise();
                $exercise->getStatus()->setId($_POST['status']);
                $exercise->setId($id);
                $exercise->editStatus();
            }
        } catch (Exception $e) {
            return $e;
        }
    }
    function delete()
    {
        try {
            if (isset($_POST['id'])) {
                $exercise = new Exercise();
                $id = intval($_POST['id']);
                $exercise = Exercise::get($id);
                $exercise->remove();
            }
        } catch (Exception $e) {
            return "error";
        }
    }
}
