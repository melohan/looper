<?php

use App\Models\Question;
use PHPUnit\Framework\TestCase;

include_once "./config/db.php";

class QuestionTest extends TestCase
{

    protected function setUp(): void
    {
        // TODO update db refresh mechanism
        $command = ' mysql --user="' . USER . '" --database="' . DB_NAME . '" --password="' . PWD . '" < "./database/testDataBase.sql"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\Question::get
     */
    public function testGet_getFirstQuestion_returnObject()
    {
        $question = Question::get(1);
        self::assertSame("Question 1", $question->getText());
    }

    /**
     * @covers \App\Models\Question::get
     */
    public function testGet_invalidId_returnNull()
    {
        $empty = Question::get(15);     // id = 15 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Question::edit
     * @depends testGet_getFirstQuestion_returnObject
     */
    public function testEdit_editTextAttribute_textChanged()
    {
        // Get existing Exercise
        $question = Question::get(2);
        $text = 'Question edited';
        $question->setText($text);
        $question->edit();
        // get current db record
        $questionEdited = Question::get(2);
        self::assertSame($text, $questionEdited->getText());
    }


    /**
     * @covers  \App\Models\Question::edit
     * @depends testGet_getFirstQuestion_returnObject
     */
    public function testEdit_editExercise_exerciseIdChanged()
    {
        // Get existing Exercise
        $question = Question::get(2);
        $id = 3;
        $question->getExercise()->setId($id);
        $question->edit();
        // get current db record
        $questionEdited = Question::get(2);
        self::assertSame($id, $questionEdited->getExercise()->getId());
    }

    /**
     * @covers  \App\Models\Question::edit
     * @depends testGet_getFirstQuestion_returnObject
     */
    public function testEdit_editQuestionType_typeIdChanged()
    {
        // Get existing Exercise
        $question = Question::get(2);
        $id = 3;
        $question->getType()->setId($id);
        $question->edit();
        // get current db record
        $questionEdited = Question::get(2);
        self::assertSame($id, $questionEdited->getType()->getId());
    }

    /**
     * @covers  \App\Models\Question::remove
     * @depends testGet_getFirstQuestion_returnObject
     */
    public function testRemove_removeValidId_entryDeleted()
    {
        $question = Question::get(2);
        $question->remove();
        $deleted = Question::get(2);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\Question::remove
     */
    public function testRemove_removeInvalidId_ThrowException()
    {
        $question = Question::get(1);
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');
        // Remove first exercise will throw and exception
        // because it is used as a foreign key
        $question->remove();
    }

    /**
     * @covers  \App\Models\Question::create
     */
    public function testCreate_createQuestion_returnLastInsertId()
    {
        $question = new Question();
        $name = 'New Exercise';
        $question->setText($name);
        $question->getType()->setId(1);
        $question->getExercise()->setId(1);
        $id = $question->create();
        self::assertSame(9, $id);
    }


}