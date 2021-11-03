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


}