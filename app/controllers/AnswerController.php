<?php

namespace App\Controllers;

use App\Models\Answer;

class AnswerController extends Controller
{
    function user()
    {
        return $this->view('answer.user');
    }

    function question()
    {
        return $this->view('answer.question');
    }

    function exercise($id)
    {
        $answers = Answer::exist($id) ? Answer::getAnswersBy(['question_id' => $id]) : [];
        return $this->view('answer.exercise', compact('answers'));
    }


}