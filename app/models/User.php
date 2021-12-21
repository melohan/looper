<?php

namespace App\Models;

use App\Database\QueryBuilder;

class User extends Model
{

    private int $id;
    private string $name;

    /**
     * Set all attributes if all parameters have been assigned.
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(int $id = null, string $name = "")
    {
        if ($id != null && $name != "") {
            $this->id = $id;
            $this->name = $name;
        }
    }

    /*      Setter & getters    */

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /*     Operations      */

    static function get(int $id): User|null
    {
        $selection = User::getById($id);
        if (!count($selection)) {
            return null;
        }
        $user = new User($selection['id'], $selection['name']);
        return $user;
    }

    public function edit(): void
    {
        self::update(['name' => $this->name], $this->id);
    }

    public function remove(): void
    {
        self::delete($this->id);
    }

    public function create(): int|false
    {
        $result = parent::insert(['name' => $this->name]);
        if (!is_int($result)) {
            return false;
        } else {
            $this->id = $result;
            return $this->id;
        }

    }

    public static function toObject(array $params): User|null
    {
        if (empty($params)) {
            return null;
        }
        $o = new User();
        if (isset($params['id'])) {
            $o->id = $params['id'];
        }
        $o->name = $params['name'];

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
     * Return array object of users by exercise id
     * @param int $exerciseId
     * @return array
     */
    public static function getByExercise(int $exerciseId): array|null
    {
        $q = new QueryBuilder();
        $query = $q
            ->select(['users.id', 'users.name'])->from('answers')
            ->join('questions', 'answers.question_id', 'questions.id')
            ->join('users', 'answers.user_id', 'users.id')
            ->whereColumn('questions.exercise_id', '=', 'exerciseId')
            ->groupBy('users.id')
            ->orderBy('users.name', 'DESC')
            ->build();
        $selection = self::selectMany($query, ['exerciseId' => $exerciseId]);
        return empty($selection) ? null : self::toObjectMany($selection);
    }

}
