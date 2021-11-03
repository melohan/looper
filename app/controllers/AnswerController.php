<?php

namespace App\Controllers;

class AnswerController extends Controller
{
    function answer()
    {
        return $this->view('answer.answer');
    }

    function answerUser()
    {
        return $this->view('answer.answerUser');
    }

    function result()
    {
        return $this->view('answer.result');
    }

}