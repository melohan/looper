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
        $questions = Exercise::exist($id) ? Question::toObjectMany(Question::selectManyWhere('exercise_id', $id)) : [];
        return $this->view('answer.exercise', compact('exercise', 'questions'));
    }

    function new(int $exerciseId)
    {
        if (isset($_POST) && Exercise::exist($exerciseId)) {
            $exercise = Exercise::get($exerciseId);

            $user = new User();
            $user->setName(date("Y-m-d H:i:s") . ' UTC');
            $userId = $user->create();
            $tmpQuestion = '';
            foreach ($_POST['fulfillment'] as $answers_attributes => $array) {
                foreach ($array as $post)
                    if (array_key_exists('questionId', $post)) {
                        $tmpQuestion = $post['questionId'];
                    } else {
                        $answer = new Answer();
                        $answer->setAnswer($post['value']);
                        $answer->setUser($userId);
                        $answer->setQuestion($tmpQuestion);
                        $answer->create();
                    }
            }
            header('Location: /answer/exercise/' . $exerciseId . "/edit/" . $userId);
        }
    }

    function edit(int $exerciseId, int $userId)
    {
        if (Exercise::exist($exerciseId) && User::exist($userId)) {
            $exercise = Exercise::get($exerciseId);
            $answers = Answer::getAnswersByExercise($exerciseId, ['user_id' => $userId]);
            return $this->view('answer.edit', compact('exercise', 'answers', 'userId'));
        }
    }

    function update(int $exerciseId, int $userId)
    {
        if (Exercise::exist($exerciseId) && User::exist($userId)) {
            // TODO replace by exist
            $answers = Answer::getAnswersByExercise($exerciseId, ['user_id' => $userId]);
            if (!is_null($answers) && isset($_POST)) {
                foreach ($_POST['fulfillment'] as $answers_attributes => $array) {
                    foreach ($array as $post)
                        if (isset($post['questionId'])) {
                            $tmpQuestion = $post['questionId'];
                        } else {
                            $answer = Answer::getAnswers($tmpQuestion, $userId);
                            $answer->setAnswer($post['value']);
                            $answer->setUser($userId);
                            $answer->setQuestion($tmpQuestion);
                            $answer->edit();
                        }
                }
                header('Location: /answer/exercise/' . $exerciseId . "/edit/" . $userId);
            }
        }
    }

}