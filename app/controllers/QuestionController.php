<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\Models\Question;
use App\Models\Type;
use Exception;

class QuestionController extends Controller
{
    function index()
    {
        return $this->view('question.create');
    }

    function fields($id = null)
    {
        if(is_null($id)){
            return $this->view(('page.error404'));
        }     

        try{            
            $getExercise = Exercise::selectById($id);
            $getQuestion = Question::selectManyWhere('exercise_id', $id);
            $getType = Type::selectAll();
            return $this->view(('exercise.fields'),compact('getExercise', 'getQuestion','getType'));
        }catch(Exception $e){   
            return $this->view(('exercise.fields'));
        }
    }
    
    function edit($id)
    {
        return $this->view('exercise.edit');
    }
}
