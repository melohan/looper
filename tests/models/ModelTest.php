<?php

/**
 * Test model through Status because this parent class is abstract
 *
 */

use App\Models\Status;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

/**
 * @covers \App\Models\Status
 */
class ModelTest extends TestCase
{

    protected function setUp(): void
    {
        // Re-execute SCRIPT before each test
        $command = ' mysql --user="' . TEST_USER . '" --database="' . TEST_DB_NAME . '" --password="' . TEST_PASSWORD . '" < "tests/models/config/' . TEST_SCRIPT . '"';
        shell_exec($command);
    }


    /**
     * @covers \App\Models\Status::Select
     */
    public function testSelectOneEntry()
    {
        // The 1st and only entry is accessed through the case 0 because this function is based on select many
        $arrayStatus = Status::select("SELECT * FROM Status WHERE id = :id", ['id' => 1])[0];
        self::assertSame(['id' => '1', 'name' => 'Building'], $arrayStatus);
    }

    /**
     * @covers \App\Models\Status::SelectAll
     */
    public function testSelectAll()
    {
        $all = Status::selectAll();
        self::assertSame(3, count($all));
    }

    /**
     * @covers \App\Models\Status::selectById
     */
    public function testSelectById()
    {
        $arrayStatus = Status::selectById(1);
        self::assertSame(['id' => '1', 'name' => 'Building'], $arrayStatus);
    }

    /**
     * @covers \App\Models\Status::selectById
     */
    public function testSelectNotExist()
    {
        $result = Status::selectById(10);
        self::assertSame(0, count($result));
    }

    /**
     * @covers \App\Models\Status::selectWhere
     */
    public function testSelectWhere()
    {
        $arrayStatus = Status::selectWhere('name', 'Answering');    // correspond to id 2
        self::assertSame(2, intval($arrayStatus['id']));
    }

    /**
     * @covers \App\Models\Status::selectWhere
     */
    public function testSelectWhereNotExist()
    {
        $arrayStatus = Status::selectWhere('name', 'My test');    // correspond to id 2
        self::assertSame(0, count($arrayStatus));
    }

    /**
     * @covers  \App\Models\Status::delete
     * @depends testSelectById
     */
    public function testDelete()
    {
        Status::delete(3);
        $arrayStatus = Status::selectById(3);
        self::assertSame(0, count($arrayStatus));
    }

    /**
     * @covers  \App\Models\Status::delete
     * @depends testSelectById
     */
    public function testDeleteThrowException()
    {
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');
        Status::delete(1);          // Cannot be deleted, this id is used as a foreign key
    }

    /**
     * @covers  \App\Models\Status::execute
     * @depends testSelectById
     */
    public function testExecuteDelete()
    {
        Status::execute("DELETE FROM Status WHERE id = :id", ['id' => 3]);
        $arrayStatus = Status::selectById(3);
        self::assertSame(0, count($arrayStatus));
    }

    /**
     * @covers  \App\Models\Status::execute
     * @depends testSelectById
     */
    public function testExecuteUpdate()
    {
        Status::execute('UPDATE status SET name = "Updated" WHERE id = :id', ['id' => 1]);
        $arrayStatus = Status::selectById(1);
        self::assertSame('Updated', $arrayStatus['name']);
    }

    /**
     * @covers \App\Models\Status::insert
     */
    public function testInsert()
    {
        $id = Status::insert(['name' => 'New Status']);
        self::assertSame(4, $id);
    }

    /**
     * @covers \App\Models\Status::insert
     */
    public function testInsertWithAlreadyTakenName()
    {
        self::assertFalse(Status::insert(['name' => 'Answering']));
    }

    /**
     * @covers  \App\Models\Status::update
     * @depends testSelectById
     */
    public function testUpdate()
    {
        Status::update(1, ['name' => 'Updated']);
        $arrayStatus = Status::selectById(1);
        self::assertSame('Updated', $arrayStatus['name']);
    }

}