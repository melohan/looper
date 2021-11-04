<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\Models\Question;
use App\Models\Type;
use Exception;

class QuestionController extends Controller
{
    function fields($id = null)
    {
        if(is_null($id)){
            return $this->view(('page.error404'));
        }     

        try{            
            $getExercise = Exercise::selectById($id);
            $getQuestion = Question::selectManyWhere('exercise_id', $id);
            $getType = Type::selectAll();
            return $this->view(('question.fields'),compact('getExercise', 'getQuestion','getType'));
        }catch(Exception $e){   
            return $this->view(('question.fields'));
        }
    }
    
    function edit()
    {
        return $this->view('question.edit');
    }

    function create()
    {
        try{            
            $name = htmlentities($_POST['name']);
            $exerciseId = htmlentities($_POST['exerciseId']);
            $typeId = htmlentities($_POST['typeId']);
            
            $question = new Question();
            $question->setText($name);
            $question->getType()->setId($typeId);
            $question->getExercise()->setId($exerciseId);
            $question->create();
            header('Location: /question/fields/' . $exerciseId);
        }catch(Exception $e){   
            return $this->view(('question.fields'));
        }        
    }
}
