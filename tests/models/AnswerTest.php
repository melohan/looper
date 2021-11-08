<?php

use App\Models\Answer;
use PHPUnit\Framework\TestCase;

include "./config/db.php";

class AnswerTest extends TestCase
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
    public function testGet_getFirstAnswer_returnObject()
    {
        $answer = Answer::get(1);
        self::assertSame("Answer 1", $answer->getAnswer());
    }

    /**
     * @covers \App\Models\Exercise::get
     */
    public function testGet_invalidId_returnNull()
    {
        $empty = Answer::get(15);     // id = 15 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Exercise::edit
     * @depends testGet_getFirstAnswer_returnObject
     */
    public function testEdit_editTextAttribute_textChanged()
    {
        // Get existing Exercise
        $answer = Answer::get(2);
        $txtAnswer = 'Answer edited';
        $answer->setAnswer($txtAnswer);
        $answer->edit();
        // We recover again to not test the setter but the database.
        $edited = Answer::get(2);
        self::assertSame($txtAnswer, $edited->getAnswer());
    }

    /**
     * @covers  \App\Models\Exercise::edit
     * @depends testGet_getFirstAnswer_returnObject
     */
    public function testEdit_editAnswerUserId_userIdChanged()
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
     * @depends testGet_getFirstAnswer_returnObject
     */
    public function testEdit_editQuestionId_Question()
    {
        // Get existing Exercise
        $answer = Answer::get(2);
        $old = $answer->getQuestion()->getId();
        $answer->getQuestion()->setId(4);
        $answer->edit();
        // We recover again to not test the setter but the database.
        $edited = Answer::get(2);
        self::assertNotSame($old, $edited->getUser()->getId());
    }


    /**
     * @covers  \App\Models\Exercise::remove
     * @depends testGet_getFirstAnswer_returnObject
     */
    public function testRemove_removeQuestionById_getRemovedIdReturnNull()
    {
        $answer = Answer::get(2);
        $answer->remove();
        $deleted = Answer::get(2);
        self::assertNull($deleted);
    }


    /**
     * @covers  \App\Models\Exercise::create
     */
    public function testCreate_createAnswer_getReturnCreatedAnswer()
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