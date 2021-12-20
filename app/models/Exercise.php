<?php

namespace App\Models;


use App\Database\QueryBuilder;

class Exercise extends Model
{
    private int $id;
    private string $title;
    private Status $status;

    /**
     * Initialize status object and set attributes if all parameters have been assigned.
     * @param int|null $id
     * @param string|null $title
     * @param int|null $statusId
     */
    public function __construct(int $id = null, string $title = '', int $statusId = null)
    {
        $this->status = new Status();
        if (!is_null($id) && !is_null($statusId)) {
            $this->id = $id;
            $this->title = $title;
            $this->status = Status::get($statusId);
        }
    }

    /*      Setter & getters    */

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }


    /*     Operations  */

    static function get(int $id): Exercise|null
    {
        $selection = self::getById($id);
        if (!count($selection)) {
            return null;
        }
        return new Exercise($selection['id'], $selection['title'], $selection['status_id']);;
    }

    public function edit(): void
    {
        self::update(['title' => $this->title, 'status_id' => $this->status->getId()], $this->id,);
    }

    public function remove(): void
    {
        self::delete($this->id);
    }

    public function create(): int|false
    {
        $result = self::insert(['title' => $this->title, 'status_id' => $this->status->getId()]);
        if (!is_int($result)) {
            return false;
        } else {
            $this->id = $result;
            return $this->id;
        }
    }

    public static function toObject(array $params): Exercise|null
    {
        if (empty($params)) {
            return null;
        }
        $o = new Exercise();
        $o->status = new Status();

        if (isset($params['id']))
            $o->id = $params['id'];
        $o->title = $params['title'];
        $o->status = Status::get($params['status_id']);
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

    /*   Object Specialized  Operations  */


    /**
     * Get exercise by questions or answers fields
     * @param array $params
     */
    public static function getByMultiple(array $params, bool $getOne = true): array|null
    {
        $q = new QueryBuilder();
        $query = $q->select(['exercises.id', 'exercises.title', 'exercises.status_id'])
            ->from('answers')
            ->join('questions', 'questions.id', 'answers.question_id')
            ->join('exercises', 'exercises.id', 'questions.exercise_id')
            ->whereEqual($params)
            ->groupBy('exercise_id')
            ->build();
        $result = self::selectMany($query, $params);
        return empty($result) ? null : self::toObjectMany($result);
    }

    /**
     * Return true if current exercise has question.
     * @return bool
     */
    public function hasQuestions(): bool
    {
        $q = new QueryBuilder();
        $query = $q->selectCount('*')
            ->as('nbQuestion')
            ->from('questions')
            ->where('exercise_id', '=')
            ->build();
        $result = self::selectOne($query, ['exercise_id' => $this->id]);
        return intval($result['nbQuestion'] > 0);
    }

    /**
     * Return array of exercises by exercise status
     * @param ExerciseStatus $status
     */
    public static function getByStatus(int $statusId): array|null
    {
        $q = new QueryBuilder();
        $query = $q->select()
            ->from('exercises')
            ->where('status_id', '=')
            ->build();
        $result = self::selectMany($query, ['status_id' => $statusId]);
        return empty($result) ? null : self::toObjectMany($result);
    }

    /**
     * Get question by current exercise
     * @return array|null
     */
    public function getQuestions(): array|null
    {
        return Question::getWhere(['exercise_id' => $this->id]);
    }

    /**
     * Get array object where params condition.
     * @param array $params
     * @return array|null
     */
    public static function getWhere(array $params): array|null
    {
        $q = new QueryBuilder();
        $query = $q->select()->from('Exercises')->whereEqual($params)->build();
        $result = self::selectMany($query, $params);
        return empty($result) ? null : self::toObjectMany($result);
    }

    /**
     * Changes the status of the current question. The change was made in the status
     * object of the current exercise instance.
     */
    public function editStatus(): void
    {
        $this->update(['status_id' => $this->status->getId()], $this->id);
    }

}