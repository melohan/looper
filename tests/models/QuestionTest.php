<?php

use App\Models\Question;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

class QuestionTest extends TestCase
{

    protected function setUp(): void
    {
        // Re-execute SCRIPT before each test
        $command = ' mysql --user="' . TEST_USER . '" --database="' . TEST_DB_NAME . '" --password="' . TEST_PASSWORD . '" < "tests/models/config/' . TEST_SCRIPT . '"';
        shell_exec($command);
    }


    /**
     * @covers \App\Models\Question::get
     */
    public function testGet()
    {
        $question = Question::get(1);
        self::assertSame("Question 1", $question->getText());
    }

    /**
     * @covers \App\Models\Question::get
     */
    public function testGetNull()
    {
        $empty = Question::get(15);     // id = 15 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Question::edit
     * @depends testGet
     */
    public function testEditText()
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
     * @depends testGet
     */
    public function testEditExercise()
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
     * @depends testGet
     */
    public function testEditType()
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
     * @depends testGet
     */
    public function testRemove()
    {
        $question = Question::get(2);
        $question->remove();
        $deleted = Question::get(2);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\Question::remove
     */
    public function testRemoveThrowException()
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
    public function testCreate()
    {
        $question = new Question();
        $name = 'New Exercise';
        $question->setText($name);
        $question->getType()->setId(1);
        $question->getExercise()->setId(1);
        $id = $question->create();


        // id will be set as 4th record
        self::assertSame(9, $question->getId());
    }


}