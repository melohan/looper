<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\User;

class AnswerController extends Controller
{
    function user(int $userId, int $exerciseId)
    {
        $exercise = User::exist($userId) && Exercise::exist($exerciseId) ? Answer::getExercisesBy(['user_id' => $userId]) : null;
        $answers = User::exist($userId) && Exercise::exist($exerciseId) ? Answer::getAnswersByExercise($exerciseId, ['user_id' => $userId]) : [];
        return $this->view('answer.user', compact('answers', 'exercise'));
    }

    function question(int $id)
    {
        $exercise = Question::exist($id) ? Answer::getExercisesBy(['question_id' => $id]) : null;
        $answers = Question::exist($id) ? Answer::getAnswersBy(['question_id' => $id]) : [];
        return $this->view('answer.question', compact('answers', 'exercise'));
    }

    function exercise(int $id)
    {
        $exercise = Exercise::get($id);
        $answers = Exercise::exist($id) ? Answer::getAnswersByExercise($id) : [];
        return $this->view('answer.exercise', compact('answers', 'exercise'));
    }


}