<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\Models\Question;
use App\Models;

class QuestionController extends Controller
{
    function index()
    {
        return $this->view('question.create');
    }
}
