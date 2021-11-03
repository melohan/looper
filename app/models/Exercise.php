<?php

namespace App\Models;


class Exercise extends Model
{

    private int    $id;
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

        if ($id != null && $title != null) {
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
        $this->update($this->id, ['title' => $this->title]);
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


}