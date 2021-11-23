<?php

namespace App\Models;


use function PHPUnit\Framework\isEmpty;

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
    public function __construct(int $id = null, string $title = null, int $statusId = null)
    {
        $this->status = new Status();
        // TODO correct id != null OR
        if ($id != null || $title != null) {
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

    /*     Operations      */

    static function get(int $id): Exercise|null
    {
        $selection = parent::selectWhere('id', $id);
        if (!count($selection)) {
            return null;
        }
        $exercise = new Exercise($selection['id'], $selection['title'], $selection['status_id']);
        return $exercise;
    }

    public function remove(): void
    {
        $this->delete($this->id);
    }

    public function edit(): void
    {
        $this->update($this->id, ['title' => $this->title, 'status_id' => $this->status->getId()]);
<<<<<<< HEAD
=======
    }

    public function editStatus(): void
    {
        $this->update($this->id, ['status_id' => $this->status->getId()]);
>>>>>>> feature/manage
    }

    public function create(): int|false
    {
        $result = parent::insert(['title' => $this->title, 'status_id' => $this->status->getId()]);
        if ($result === false) {
            return false;
        } else {
            $this->id = $result;
            return $this->id;
        }
    }

    /**
     * Return true if current exercise has question.
     * @return bool
     */
    public function hasQuestions(): bool
    {
        $query = 'SELECT COUNT(answers.question_id) FROM answers GROUP BY answers.question_id HAVING question_id = :question_id';
        return count(self::select($query, ['question_id' => $this->id])) != 0;
    }

    /**
     * Return array of exercises by exercise status
     * @param ExerciseStatus $status
     */
    public static function selectByStatus(int $statusId)
    {
        $query = "SELECT * FROM exercises WHERE status_id = :status_id";
        $selection = parent::select($query, ['status_id' => $statusId]);
        return self::toObjectMany($selection);
    }

    /**
     * Convert associative array to object
     * @param array $params
     */
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
<<<<<<< HEAD

    public function getQuestions(): array|null
    {
        $questions = Question::selectManyWhere('exercise_id', $this->id);
        return  Question::toObjectMany($questions);
    }

}
=======
}
>>>>>>> feature/manage
