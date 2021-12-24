<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\User;

class AnswerController extends Controller
{
    /**
     * Return answers by user and exercise id
     * If user and answers doesn't exist it returns an empty page.
     * @param int $userId
     * @param int $exerciseId
     */
    function user(int $userId, int $exerciseId)
    {
        $exercise = Answer::getExercisesBy(['user_id' => $userId]);
        $answers = Answer::getAnswersByExercise($exerciseId, ['user_id' => $userId]);
        return $this->view('answer.user', compact('answers', 'exercise'));
    }

    /**
     * Return answers by question id
     * @param int $id
     */
    function question(int $id)
    {
        $question = Question::get($id);
        $exercise = Answer::getExercisesBy(['question_id' => $id]);
        $answers = Answer::getAnswersBy(['question_id' => $id]);
        return $this->view('answer.question', compact('answers', 'exercise', 'question'));
    }

    /**
     * Return answers by exercise id
     * @param int $id
     */
    function exercise(int $id)
    {
        $exercise = Exercise::get($id);
        $questions = Question::getManyBy(['exercise_id' => $id]);
        $users = !is_null($exercise) ? User::getByExercise($exercise->getId()) : null;
        return $this->view('answer.exercise', compact('exercise', 'questions', 'users'));
    }

    /**
     * Create a new answers and redirect to the exercise answer's edition page.
     * @param int $exerciseId
     */
    function new(int $exerciseId)
    {
        if (isset($_POST) && Exercise::exist($exerciseId)) {
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

    /**
     * Return answer edition page.
     * It returns an empty page if exercise and user id is empty
     * @param int $exerciseId
     * @param int $userId
     */
    function edit(int $exerciseId, int $userId)
    {
        $exercise = Exercise::get($exerciseId);
        $answers = Answer::getAnswersByExercise($exerciseId, ['user_id' => $userId]);
        return $this->view('answer.edit', compact('exercise', 'answers', 'userId'));
    }

    /**
     * Update answers with posted value and redirect to edition form.
     * Once data is updated, it redirects to edition page.
     * @param int $exerciseId
     * @param int $userId
     */
    function update(int $exerciseId, int $userId)
    {
        if (Exercise::exist($exerciseId) && User::exist($userId)) {
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