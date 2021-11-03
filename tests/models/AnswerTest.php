<?php

use App\Models\Answer;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

class AnswerTest extends TestCase
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
        $answer = Answer::get(1);
        self::assertSame("Answer 1", $answer->getAnswer());
    }

    /**
     * @covers \App\Models\Exercise::get
     */
    public function testGetNull()
    {
        $empty = Answer::get(15);     // id = 15 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Exercise::edit
     * @depends testGet
     */
    public function testEditAnswer()
    {
        // Get existing Exercise
        $answer = Answer::get(2);
        $txtAnswer = 'Answer edited';
        $answer->setAnswer($txtAnswer);
        $answer->edit();
        self::assertSame($txtAnswer, $answer->getAnswer());
    }

    /**
     * @covers  \App\Models\Exercise::edit
     * @depends testGet
     */
    public function testEditUser()
    {
        // Get existing Exercise
        $answer = Answer::get(2);
        $old = $answer->getUser()->getId();
        $answer->getUser()->setId(3);
        $answer->edit();
        // Get current record
        $edited = Answer::get(2);
        self::assertNotSame($old, $edited->getUser()->getId());
    }

    /**
     * @covers  \App\Models\Exercise::edit
     * @depends testGet
     */
    public function testEditQuestion()
    {
        // Get existing Exercise
        $answer = Answer::get(2);
        $old = $answer->getQuestion()->getId();
        $answer->getQuestion()->setId(4);
        $answer->edit();
        // Get current record
        $edited = Answer::get(2);
        self::assertNotSame($old, $edited->getUser()->getId());
    }


    /**
     * @covers  \App\Models\Exercise::remove
     * @depends testGet
     */
    public function testRemove()
    {
        $answer = Answer::get(2);
        $answer->remove();
        $deleted = Answer::get(2);
        self::assertNull($deleted);
    }


    /**
     * @covers  \App\Models\Exercise::create
     */
    public function testCreate()
    {
        $answer = new Answer();
        $answer->setAnswer('My answer');
        $answer->getUser()->setId(1);
        $answer->getQuestion()->setId(3);
        $id = $answer->create();
        // id will be set as 4th record
        self::assertSame(8, $answer->getId());
    }


}