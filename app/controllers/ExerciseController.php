<?php

namespace App\Controllers;

use App\Models\Exercise;

use App\models\ExerciseStatus;
use App\Models\Question;
use App\Models\Status;

class ExerciseController extends Controller
{
    /**
     * Return home page
     */
    function index()
    {
        return $this->view('exercise.create');
    }

    /**
     * Return take page where exercises have ANSWERING status.
     */
    function take()
    {
        $exercises = Exercise::getWhere(['status_id' => ExerciseStatus::ANSWERING]);
        return $this->view('exercise.take', compact('exercises'));
    }

    /**
     * Return manage page with answers by exercise status
     */
    function manage()
    {
        $building = Exercise::getByStatus(ExerciseStatus::BUILDING);
        $answering = Exercise::getByStatus(ExerciseStatus::ANSWERING);
        $closed = Exercise::getByStatus(ExerciseStatus::CLOSED);
        return $this->view('exercise.manage', compact('building', 'answering', 'closed'));
    }

    /**
     * Return edition page of exercise
     */
    function edit()
    {
        return $this->view('exercise.edit');
    }

    /**
     * Return fulfillments view
     * @param int $id
     */
    function fulfillments(int $id)
    {
        $exercise = Exercise::get($id);
        return $this->view('exercise.fulfillments', compact('exercise'));
    }

    /**
     * Return creation page of exercise
     */
    function create()
    {
        $exercise = new Exercise();
        if (isset($_POST['exerciseTitle']) && Status::exist(ExerciseStatus::BUILDING)) {
            $exercise->setTitle($_POST['exerciseTitle']);
            $exercise->getStatus()->setId(ExerciseStatus::BUILDING);
            $result = $exercise->create();
            if ($result === false)
                $this->view(('exercise.create'));
            header('Location: /question/fields/' . $exercise->getId());
        }
        return $this->view(('exercise.create'));
    }

    /**
     *  Update exercise status according to current status.
     *  This content is called by JS file.
     */
    function update()
    {
        if (isset($_POST['id']) && isset($_POST['status'])) {
            $id = intval($_POST['id']);
            $exercise = Exercise::get($id);
            if (!is_null($exercise)) {
                if ($exercise->getStatus()->getId() == ExerciseStatus::BUILDING) {
                    $exercise->getStatus()->setId(ExerciseStatus::ANSWERING);
                    $exercise->setId($id);
                    $exercise->editStatus();
                } elseif ($exercise->getStatus()->getId() == ExerciseStatus::ANSWERING) {
                    $exercise->getStatus()->setId(ExerciseStatus::CLOSED);
                    $exercise->setId($id);
                    $exercise->editStatus();
                }
            }
        }
    }

    /**
     *  Delete exercise by status buildind or closed.
     *  This content is called by JS file.
     * @return string
     */
    function delete()
    {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $exercise = Exercise::get($id);
            if (!is_null($exercise) && ($exercise->getStatus()->getId() == ExerciseStatus::BUILDING || $exercise->getStatus()->getId() == ExerciseStatus::CLOSED))
                $exercise->remove();
        }
    }
}
