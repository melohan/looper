<?php

use App\Models\Exercise;
use PHPUnit\Framework\TestCase;

require_once 'config/DB.php';

class ExerciseTest extends TestCase
{

    protected function setUp(): void
    {
        // TODO update db refresh mechanism
        $command = ' mysql --user="' . USER . '" --database="' . DB_NAME . '" --password="' . PWD . '" < "./database/testDataBase.sql"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\Exercise::get
     */
    public function testGet_getFirstExercise_returnObject()
    {
        $exercise = Exercise::get(1);
        self::assertSame("Exercise 1", $exercise->getTitle());
    }

    /**
     * @covers \App\Models\Exercise::get
     */
    public function testGet_invalidId_returnNull()
    {
        $empty = Exercise::get(10);     // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Exercise::edit
     * @depends testGet_getFirstExercise_returnObject
     */
    public function testEdit_editTitleAttribute_titleChanged()
    {
        // Get existing Exercise
        $exercise = Exercise::get(2);
        $title = 'Exercise edited';
        $exercise->setTitle($title);
        $exercise->edit();
        $edited = Exercise::get(2);
        self::assertSame($title, $edited->getTitle());
    }

    /**
     * @covers  \App\Models\Exercise::remove
     * @depends testGet_getFirstExercise_returnObject
     */
    public function testRemove_removeValidId_entryDeleted()
    {
        $exercise = Exercise::get(2);
        $exercise->remove();
        $deleted = Exercise::get(2);
        self::assertNull($deleted);
    }


    /**
     * @covers  \App\Models\Exercise::create
     */
    public function testCreate_createExercise_returnLastInsertId()
    {
        $exercise = new Exercise();
        $name = 'New Exercise';
        $exercise->setTitle($name);
        $exercise->getStatus()->setId(1);
        $id = $exercise->create();
        // id will be set as 4th record
        self::assertSame(4, $id);
    }

    /**
     * @covers  \App\Models\Exercise::toObject
     * @depends testGet_getFirstExercise_returnObject
     */
    public function testToObject_toObjectFromArray_newObject()
    {
        $fromGet = Exercise::get(1);
        $params = Exercise::getById(1);
        $fromToObject = Exercise::toObject($params);
        self::assertEquals($fromGet, $fromToObject);
    }


}