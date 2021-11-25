<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\Models\Question;
use App\Models\Type;
use Exception;

class QuestionController extends Controller
{
    function fields($id)
    {
        $types = Type::allTypes();
        $exercise = Exercise::get($id);
        return $this->view(('question.fields'), compact('exercise', 'types'));
    }

    function edit($id)
    {
        $types = Type::allTypes();
        $question = Question::get(intval($id));
        return $this->view(('question.edit'), compact('question', 'types'));
    }


    function update($id)
    {
        if (isset($_POST['field']['label']) && isset($_POST['typeId'])) {
            $typeId = $_POST['typeId'];
            $text = $_POST['field']['label'];
            $question = Question::get($id);
            $question->getType()->setId($typeId);
            $question->setText($text);
            $question->edit();
            header('Location: /question/fields/' . $id);
        }
    //    header('Location: /question/fields/' . $id);
    }


    function create()
    {
        try {
            $name = $_POST['name'];
            $exerciseId = $_POST['exerciseId'];
            $typeId = $_POST['typeId'];

            $question = new Question();
            $question->setText($name);
            $question->getType()->setId($typeId);
            $question->getExercise()->setId($exerciseId);
            $question->create();
            header('Location: /question/fields/' . $exerciseId);
        } catch (Exception $e) {
            return $this->view(('question.fields'));
        }
    }

    function delete()
    {
        try {
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']);
                $question = Question::get($id);
                $question->remove();
            }
        } catch (Exception $e) {
            return "error";
        }
    }
}
