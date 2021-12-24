<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\models\ExerciseStatus;
use App\Models\Question;
use App\Models\Type;
use mysql_xdevapi\Exception;

class QuestionController extends Controller
{
    /**
     * Return exercise question creation page.
     * It returns an empty page if exercise doesn't exist.
     * @param $id
     */
    function fields($id)
    {
        $types = Type::getAll();
        $exercise = Exercise::get($id);
        return $this->view(('question.fields'), compact('exercise', 'types'));
    }

    /**
     * Return edition form page
     * @param $id
     */
    function edit($id)
    {
        $types = Type::getAll();
        $question = Question::get(intval($id));
        return $this->view(('question.edit'), compact('question', 'types'));
    }

    /**
     * Update post from edit page
     * Return 404 error page if question does not exist
     * @param $id
     */
    function update($id)
    {
        $question = Question::get($id);

        // Check posted value and exercise status
        if (!is_null($question)
            && (isset($_POST['field']['label']) || isset($_POST['typeId']))
            && $question->getExercise()->getStatus()->getId() == ExerciseStatus::BUILDING) {

            // If typeId is not updated, we retrieve its current value
            $typeId = isset($_POST['typeId']) ? $_POST['typeId'] : $question->getType()->getId();
            $text = isset($_POST['field']['label']) ? $_POST['field']['label'] : $question->getText();

            $question->getType()->setId($typeId);
            $question->setText($text);
            $question->edit();
        } else {
            header('Location: /page/error/404');
        }
        header('Location: /question/fields/' . $question->getExercise()->getId());
    }

    /**
     * Create question and redirect to /question/fields page of created question.
     * If there is an issue with the form post, this method return to home page
     */
    function create()
    {
        if (isset($_POST['exerciseId'])
            && Exercise::exist($_POST['exerciseId'])
            && isset($_POST['typeId'])
            && Type::exist($_POST['typeId'])) {

            $name = $_POST['name'] ?: "";
            $exerciseId = $_POST['exerciseId'];
            $typeId = $_POST['typeId'];
            $question = new Question();
            $question->setText($name);
            $question->getType()->setId($typeId);
            $question->getExercise()->setId($exerciseId);
            $question->create();
            header('Location: /question/fields/' . $exerciseId);

        } else {
            header('Location: /');
        }
    }

    /**
     * Delete the question whose exercise is being edited
     * this method is called by delete button and used by js file
     */
    function delete()
    {
        $question = Question::get($_POST['id']);
        // If there is a post and if its exercise status is BUILDING
        if (isset($_POST['id']) && !is_null($question) && $question->getExercise()->getStatus() == ExerciseStatus::BUILDING) {
            $question->remove();
        }
    }

}
