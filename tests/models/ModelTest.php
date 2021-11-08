<?php

/**
 * Test model through Status because this parent class is abstract
 *
 */

use App\Models\Status;
use PHPUnit\Framework\TestCase;

include_once "./config/db.php";

/**
 * @covers \App\Models\Status
 */
class ModelTest extends TestCase
{

    protected function setUp(): void
    {
        // TODO update db refresh mechanism
        $command = ' mysql --user="' . USER . '" --database="' . DB_NAME . '" --password="' . PWD . '" < "./database/testDataBase.sql"';
        shell_exec($command);
    }


    /**
     * @covers \App\Models\Status::Select
     */
    public function testSelectOne_selectOneEntry_returnArray()
    {
        // The 1st and only entry is accessed through the case 0 because this function is based on select many
        $arrayStatus = Status::select("SELECT * FROM Status WHERE id = :id", ['id' => 1])[0];
        self::assertSame(['id' => '1', 'name' => 'Building'], $arrayStatus);
    }

    /**
     * @covers \App\Models\Status::SelectAll
     */
    public function testSelectAll_selectAllStatus_return2DArray()
    {
        $all = Status::selectAll();
        self::assertSame(3, count($all));
    }

    /**
     * @covers \App\Models\Status::selectById
     */
    public function testSelectById_SelectFirstStatus_returnArray()
    {
        $arrayStatus = Status::selectById(1);
        self::assertSame(['id' => '1', 'name' => 'Building'], $arrayStatus);
    }

    /**
     * @covers \App\Models\Status::selectById
     */
    public function testSelectById_SelectInvalidStatus_returnEmptyArray()
    {
        $result = Status::selectById(10);
        self::assertSame(0, count($result));
    }

    /**
     * @covers \App\Models\Status::selectWhere
     */
    public function testSelectWhere_statusNameEqualTo_returnArray()
    {
        $arrayStatus = Status::selectWhere('name', 'Answering');    // correspond to id 2
        // Check one field of this array
        self::assertSame(2, intval($arrayStatus['id']));
    }

    /**
     * @covers \App\Models\Status::selectWhere
     */
    public function testSelectWhere_selectInvalidStatus_returnEmptyArray()
    {
        $arrayStatus = Status::selectWhere('name', 'My test');    // correspond to id 2
        self::assertSame(0, count($arrayStatus));
    }

    /**
     * @covers  \App\Models\Status::delete
     * @depends testSelectById_SelectFirstStatus_returnArray
     */
    public function testDelete_deleteStatus_statusDeleted()
    {
        Status::delete(3);
        $arrayStatus = Status::selectById(3);
        self::assertSame(0, count($arrayStatus));
    }

    /**
     * @covers  \App\Models\Status::delete
     * @depends testSelectById_SelectFirstStatus_returnArray
     */
    public function testDelete_deleteInvalidId_throwException()
    {
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');
        Status::delete(1);          // Cannot be deleted, this id is used as a foreign key
    }

    /**
     * @covers  \App\Models\Status::execute
     * @depends testSelectById_SelectFirstStatus_returnArray
     */
    public function testExecute_executeDelete_entryDeleted()
    {
        Status::execute("DELETE FROM Status WHERE id = :id", ['id' => 3]);
        $arrayStatus = Status::selectById(3);
        self::assertSame(0, count($arrayStatus));
    }

    /**
     * @covers  \App\Models\Status::execute
     * @depends testSelectById_SelectFirstStatus_returnArray
     */
    public function testExecute_executeUpdate_entryUpdated()
    {
        Status::execute('UPDATE status SET name = "Updated" WHERE id = :id', ['id' => 1]);
        $arrayStatus = Status::selectById(1);
        self::assertSame('Updated', $arrayStatus['name']);
    }

    /**
     * @covers \App\Models\Status::insert
     */
    public function testInsert_insertValid_returnLastInsertId()
    {
        $id = Status::insert(['name' => 'New Status']);
        self::assertSame(4, $id);
    }

    /**
     * @covers \App\Models\Status::insert
     */
    public function testInsert_insertInvalid_returnFalse()
    {
        self::assertFalse(Status::insert(['name' => 'Answering']));
    }

    /**
     * @covers  \App\Models\Status::update
     * @depends testSelectById_SelectFirstStatus_returnArray
     */
    public function testExecute_updateStatus_entryUpdated()
    {
        Status::update(1, ['name' => 'Updated']);
        $arrayStatus = Status::selectById(1);
        self::assertSame('Updated', $arrayStatus['name']);
    }

}