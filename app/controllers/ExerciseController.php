<?php

namespace App\Controllers;

use App\Models\Exercise;

use App\models\ExerciseStatus;
use App\Models\Question;
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

    function fulfillments(int $id)
    {
        if (Exercise::exist($id)) {
            $exercise = Exercise::get($id);
        }
        return $this->view('exercise.fulfillments', compact('exercise'));
    }

    function create()
    {
        $exercise = new Exercise();
        if (isset($_POST['exerciseTitle'])) {
            $exercise->setTitle($_POST['exerciseTitle']);
            $exercise->getStatus()->setId(ExerciseStatus::BUILDING);
            $result = $exercise->create();
            if ($result === false)
                $this->view(('exercise.create'));
            header('Location: /question/fields/' . $exercise->getId());
        }
        return $this->view(('exercise.create'));
    }

    function update()
    {
        try {
            if (isset($_POST['id']) && isset($_POST['status'])) {
                $id = intval($_POST['id']);
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
