<?php

namespace App\Models;

class User extends Model
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

    static function get(int $id): User|null
    {
        $selection = User::selectWhere('id', $id);
        if (!count($selection)) {
            return null;
        }
        $user = new User($selection['id'], $selection['name']);
        return $user;
    }

    public function remove(): void
    {
        $this->delete($this->id);
    }

    public function edit(): void
    {
        $this->update($this->id, ['name' => $this->name]);
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