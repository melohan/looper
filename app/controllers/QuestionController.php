<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\Models\Question;
use App\Models\Type;

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
     * @param $id
     */
    function update($id)
    {
        if (isset($_POST['field']['label']) && isset($_POST['typeId'])) {
            $typeId = $_POST['typeId'];
            $text = $_POST['field']['label'];
            $question = Question::get($id);
            $question->getType()->setId($typeId);
            $question->setText($text);
            $question->edit();
        }
        header('Location: /question/fields/' . $question->getExercise()->getId());
    }

    /**
     * Create question and redirect to /question/fields page of created question.
     */
    function create()
    {
        $name = $_POST['name'];
        $exerciseId = $_POST['exerciseId'];
        $typeId = $_POST['typeId'];
        $question = new Question();
        $question->setText($name);
        $question->getType()->setId($typeId);
        $question->getExercise()->setId($exerciseId);
        $question->create();
        header('Location: /question/fields/' . $exerciseId);
    }

    /**
     * Delete question, this method is called by delete button and used by js file
     */
    function delete()
    {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $question = Question::get($id);
            $question->remove();
        }
    }
}
