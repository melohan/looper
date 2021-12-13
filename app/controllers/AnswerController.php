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

    function new(int $exerciseId)
    {
        if (isset($_POST) && Exercise::exist($exerciseId)) {
            $exercise = Exercise::get($exerciseId);

            $user = new User();
            $user->setName(date("Y-m-d H:i:s") . ' UTC');
            $userid = $user->create();
            $tmpQuestion = '';
            foreach ($_POST['fulfillment'] as $answers_attributes => $array) {
                foreach ($array as $post)
                    if (array_key_exists('questionId', $post)) {
                        $tmpQuestion = $post['questionId'];
                    } else {
                        $answer = new Answer();
                        $answer->setAnswer($post['value']);
                        $answer->setUser($userid);
                        $answer->setQuestion($tmpQuestion);
                        $answer->create();
                    }
            }
            header('Location: /answer/exercise/' . $exerciseId . "/edit/" . $userid);
        }
    }

    function edit(int $exerciseId, int $userId)
    {
        if (Exercise::exist($exerciseId) && User::exist($userId)) {
            $exercise = Exercise::get($exerciseId);
            $answers = Answer::getAnswersByExercise($exerciseId, ['user_id' => $userId]);
            return $this->view('answer.edit', compact('exercise', 'answers'));
        }
    }


}