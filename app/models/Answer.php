<?php

namespace App\Models;

use App\Database\QueryBuilder;
use App\Models\User;
use App\Models\Question;

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
    public function __construct(int $id = null, int $questionId = null, int $userId = null, string $answer = "")
    {
        $this->user = new User();
        $this->question = new Question();

        if ($questionId != null && $userId != null) {
            $this->id = $id;
            $this->user = User::get($userId);
            $this->question = Question::get($questionId);
            $this->answer = $answer;
        }

    }

    /*      Setter & getters    */

    public function setAnswer(string $answer = "")
    {
        $this->answer = $answer;
    }

    public function setUser(int $id)
    {
        $this->user->setId($id);
    }

    public function setQuestion(int $id)
    {
        $this->question->setId($id);
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
        $selection = self::getById($id);

        if (!count($selection)) {
            return null;
        }
        return new Answer($selection['id'], $selection['question_id'], $selection['user_id'], $selection['answer']);;
    }

    public function edit(): void
    {
        self::update(
            [
                'user_id' => $this->getUser()->getId(),
                'question_id' => $this->getQuestion()->getId(),
                'answer' => $this->answer],
            $this->id);
    }

    public function remove(): void
    {
        parent::delete($this->id);
    }

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

    public static function toObjectMany(array $params): array
    {
        $result = [];
        foreach ($params as $item) {
            $result[] = self::toObject($item);
        }
        return $result;
    }

    /*
      Object Specialized  Operations
      TODO write Unit tests
      */

    /**
     * Get answers by question id and user id
     * @param int $questionId
     * @param int $userId
     * @return Answer|null
     */
    static public function getAnswers(int $questionId, int $userId): Answer|null
    {
        $q = new QueryBuilder();
        $query = $q->select()->from('answers')->whereEqual(['question_id' => $questionId, 'user_id' => $userId])->build();
        $result = parent::selectOne($query, ['question_id' => $questionId, 'user_id' => $userId]);
        return empty($result) ? null : self::toObject($result);
    }

    /**
     * Return Answers array objects by exercise id
     * @param int $exerciseId
     * @return array|null
     */
    static public function getAnswersByExercise(int $exerciseId, array $params = []): array|null
    {
        $q = new QueryBuilder();
        $query = $q->select(['answers.id', 'answers.question_id', 'answers.user_id', 'answers.answer'])
            ->from('answers')
            ->join('questions', 'questions.id', 'answers.question_id')
            ->join('exercises ', 'exercises.id', 'questions.exercise_id')
            ->whereEqual($params)
            ->build();
        $result = self::selectMany($query, $params);
        return empty($result) ? null : self::toObjectMany($result);
    }

    /**
     * Get Answers by parameters
     * @return Answer|null
     */
    static public function getAnswersBy(array $params): array|null
    {
        $q = new QueryBuilder();
        $query = $q->select()->from('answers')->whereEqual($params)->build();
        $result = self::selectMany($query, $params);
        return empty($result) ? null : self::toObjectMany($result);
    }

    /**
     * Get Exercises by answers fields
     * @param array $params
     * @return Exercise|null
     */
    static public function getExercisesBy(array $params): Exercise|null
    {
        $q = new QueryBuilder();
        $query = $q
            ->select(['exercises.id', 'exercises.title', 'exercises.status_id'])
            ->from('answers')
            ->join('questions', 'questions.id', 'answers.question_id')
            ->join('exercises', 'exercises.id', 'questions.exercise_id')
            ->whereEqual($params)
            ->groupBy('exercises.id')
            ->build();
        $result = self::selectOne($query, $params);
        return empty($result) ? null : Exercise::toObject($result);
    }


}