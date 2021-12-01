<?php

namespace App\Controllers;

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

    function exercise()
    {
        return $this->view('answer.exercise');
    }


}