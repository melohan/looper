<?php

namespace App\Models;

class Type extends Model
{

    private int $id;
    private string $name;

    /**
     * Set all attributes if all parameters have been assigned.
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(int $id = null, string $name = null)
    {
        if ($id != null && $name != null) {
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

    static public function get(int $id): Type|null
    {
        $selection = self::getById($id);
        if (count($selection) == 0) {
            return null;
        }
        return new Type($selection['id'], $selection['name']);
    }

    public function edit(): void
    {
        self::update(['name' => $this->name], $this->id);
    }

    public function remove(): void
    {
        parent::delete($this->id);
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

    public static function toObject(array $params): Type|null
    {
        if (empty($params)) {
            return null;
        }
        $o = new Type();
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

    /*   Object Specialized  Operations  */

    public static function getAll(): array
    {
        $all = parent::getAll();
        return self::toObjectMany($all);
    }

}