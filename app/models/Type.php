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
    public git function __construct(int $id = null, string $name = null)
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
        $selection = parent::selectById($id);
        if (count($selection) == 0) {
            return null;
        }
        return new Type($selection['id'], $selection['name']);
    }

    public function edit(): void
    {
        $this->update($this->id, ['name' => $this->name]);
    }

    public function remove(): void
    {
        $this->delete($this->id);
    }

    public function create(): int|false
    {
        $result = parent::insert(['name' => $this->name]);
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

    // todo Correct function name
    public static function allTypes():array{
       $all = Type::selectAll();
       return self::toObjectMany($all);
    }


}