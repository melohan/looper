<?php

use App\Models\Exercise;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

class ExerciseTest extends TestCase
{

    protected function setUp(): void
    {
        // Re-execute SCRIPT before each test
        $command = ' mysql --user="' . TEST_USER . '" --database="' . TEST_DB_NAME . '" --password="' . TEST_PASSWORD . '" < "tests/models/config/' . TEST_SCRIPT . '"';
        shell_exec($command);
    }


    /**
     * @covers \App\Models\Exercise::get
     */
    public function testGet()
    {
        $exercise = Exercise::get(1);
        self::assertSame("Exercise 1", $exercise->getTitle());
    }

    /**
     * @covers \App\Models\Exercise::get
     */
    public function testGetNull()
    {
        $empty = Exercise::get(10);     // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Exercise::edit
     * @depends testGet
     */
    public function testEdit()
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
     * @depends testGet
     */
    public function testRemove()
    {
        $exercise = Exercise::get(2);
        $exercise->remove();
        $deleted = Exercise::get(2);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\Exercise::remove
     */
    public function testRemoveThrowException()
    {
        $exercise = Exercise::get(1);
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');
        // Remove first exercise will throw and exception
        // because it is used as a foreign key
        $exercise->remove();
    }

    /**
     * @covers  \App\Models\Exercise::create
     */
    public function testCreate()
    {
        $exercise = new Exercise();
        $name = 'New Exercise';
        $exercise->setTitle($name);
        $exercise->getStatus()->setId(1);
        $id = $exercise->create();
        // id will be set as 4th record
        self::assertSame(4, $exercise->getId());
    }


}