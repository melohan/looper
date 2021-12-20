<?php

namespace App\Models;

use App\Database\QueryBuilder;
use App\Models\Exercise;
use App\Models\Type;


class Question extends Model
{
    private int $id;
    private string $text;
    private Exercise $exercise;
    private Type $type;

    /**
     * Initialize exercise, type object and set attributes if all parameters have been assigned.
     * @param int|null $id
     * @param string|null $text
     * @param int|null $exercise_id
     * @param int|null $type_id
     */
    public function __construct(int $id = null, string $text = "", int $exercise_id = null, int $type_id = null)
    {
        $this->exercise = new Exercise();
        $this->type = new Type();

        if ($id != null && $exercise_id != null && $type_id != null) {
            $this->id = $id;
            $this->text = $text;
            $this->exercise = Exercise::get($exercise_id);
            $this->type = Type::get($type_id);
        }
    }

    /*      Setter & getters    */

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getExercise(): Exercise
    {
        return $this->exercise;
    }

    public function getType(): Type
    {
        return $this->type;
    }


    /*     Operations      */

    static function get(int $id): Question|null
    {
        $selection = self::getById($id);
        if (!count($selection)) {
            return null;
        }
        return new Question($selection['id'], $selection['text'], $selection['exercise_id'], $selection['type_id']);
    }

    public function edit(): void
    {
        self::update(['text' => $this->text, 'exercise_id' => $this->exercise->getId(), 'type_id' => $this->type->getId()], $this->id);
    }

    public function remove(): void
    {
        self::delete($this->id);
    }

    public function create(): int|false
    {
        $result = parent::insert(['text' => $this->text, 'exercise_id' => $this->exercise->getId(), 'type_id' => $this->type->getId()]);

        if (!is_int($result)) {
            return false;
        } else {
            $this->id = $result;
            return $this->id;
        }
    }

    public static function toObject(array $params): Question|null
    {
        if (empty($params)) {
            return null;
        }

        $o = new Question();
        $o->exercise = new Exercise();
        $o->type = new Type();
        if (isset($params['id'])) {
            $o->id = $params['id'];
        }
        $o->text = $params['text'];
        $o->exercise = Exercise::get($params['exercise_id']);
        $o->type = Type::get($params['type_id']);
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
     * Select where params equal value
     * @param array $params
     */
    public static function getBy(array $params): Question|null
    {
        $q = new QueryBuilder();
        $query = $q->select()->from('Questions')->whereEqual($params)->build();
        $result = self::selectOne($query, $params);
        return empty($result) ? null : self::toObject($result);
    }

    /**
     * Select many where params equal value
     * @param array $params
     */
    public static function getManyBy(array $params): array|null
    {
        $q = new QueryBuilder();
        $query = $q->select()->from('Questions')->whereEqual($params)->build();
        $result = self::selectMany($query, $params);
        return empty($result) ? null : self::toObjectMany($result);
    }

    /**
     * Get array object where params condition.
     * @param array $params
     * @return array|null
     */
    public static function getWhere(array $params): array|null
    {
        $q = new QueryBuilder();
        $query = $q->select()->from('questions')->whereEqual($params)->build();
        $result = self::selectMany($query, $params);
        return empty($result) ? null : self::toObjectMany($result);
    }

}
