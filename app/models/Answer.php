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
     * Get one Answer by question and user id
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
        return new Answer($selection[0]['id'], $selection[0]['question_id'], $selection[0]['user_id'], $selection[0]['answer']);
    }


    /**
     * Get Answers
     * @return Answer|null
     */
    static public function getAnswersBy(array $params): array|null
    {
        // concatenate in and condition if params is not empty
        $keys = array_keys($params);
        $and = implode(' ', array_map(function ($item) {
            return 'AND ' . $item . ' = :' . $item;
        }, $keys));
        var_dump($and);
        $selection = parent::select("SELECT * FROM answers WHERE 1 ".$and, $params);
        var_dump($selection);
        if (!count($selection)) {
            return null;
        }
        return self::toObjectMany($selection);
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


    /**
     * Convert associative array to object
     * @param array $params
     */
    public static function toObject(array $params): Answer|null
    {
        if (empty($params)) {
            return null;
        }

        $o = new Answer();
        $o->user = new User();
        $o->question = new Question();

        if (isset($params['id'])) {
            $o->id = $params['id'];
        }
        $o->user = User::get($params['user_id']);
        $o->question = Question::get($params['question_id']);
        $o->answer = $params['answer'];
        return $o;
    }

    /**
     * Convert array of associative arrays to objects
     * Convert many to
     * @param array $params
     * @return array
     */
    public static function toObjectMany(array $params): array
    {
        $result = [];
        foreach ($params as $item) {
            $result[] = self::toObject($item);
        }
        return $result;
    }
}