<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
use function PHPUnit\Framework\isNull;

class Answer extends Model
{
    private int $id;
    private Question $question;
    private User $user;
    private string $answer;

    /**
     * Initialize user, question object and set attributes if all parameters have been assigned.
     * @param int|null $questionId
     * @param int|null $userId
     * @param string|null $answer
     */
    public function __construct(int $id = null, int $questionId = null, int $userId = null, string $answer = null)
    {
        $this->user = new User();
        $this->question = new Question();

        if ($questionId != null && $userId != null && $answer != null) {
            $this->id = $id;
            $this->user = User::get($userId);
            $this->question = Question::get($questionId);
            $this->answer = $answer;
        }

    }

    /*      Setter & getters    */

    public function setAnswer(string $answer)
    {
        $this->answer = $answer;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getId()
    {
        return $this->id;
    }

    /*     Operations      */


    static public function get(int $id): Answer|null
    {
        $selection = parent::selectWhere('id', $id);
        if (!count($selection)) {
            return null;
        }
        return new Answer($selection['id'], $selection['question_id'], $selection['user_id'], $selection['answer']);;
    }

    /**
     * get answers by question and user id
     * @param int $firstId
     * @param int $scndId
     * @return Answer|null
     */
    static public function getAnswers(int $questionId, int $userId): Answer|null
    {
        $selection = parent::select("SELECT * FROM answers WHERE answers.question_id = :question_id AND answers.user_id = :user_id", ['question_id' => $questionId, 'user_id' => $userId]);
        // select is based on select many so we need to access to [0]
        if (!count($selection)) {
            return null;
        }
        return new Answer($selection['id'], $selection['question_id'], $selection['user_id'], $selection['answer']);
    }


    public function edit(): void
    {
        parent::execute("UPDATE answers SET user_id = :user_id, question_id = :question_id, answer = :answer WHERE id = :id",
            ['user_id' => $this->getUser()->getId(), 'question_id' => $this->getQuestion()->getId(), 'answer' => $this->answer, 'id' => $this->getId()]);
    }

    public function remove(): void
    {
        parent::execute("DELETE FROM answers WHERE user_id = :user_id AND question_id  = :question_id",
            ['user_id' => $this->getUser()->getId(), 'question_id' => $this->getQuestion()->getId()]);
    }

    /**
     * Create record but doesn't return ID because of double foreign keys as id
     * @return array|false
     */
    public function create(): int|false
    {
        $result = parent::insert(['question_id' => $this->getQuestion()->getId(), 'user_id' => $this->getUser()->getId(), 'answer' => $this->getAnswer()]);

        if ($result === false) {
            return false;
        } else {
            $this->id = $result;
            return $this->id;
        }
    }
}