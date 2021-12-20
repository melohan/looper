<?php

/**
 * Test model through Status because this parent class is abstract
 */

use App\Models\Status;
use PHPUnit\Framework\TestCase;

require_once 'config/DB.php';

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
     * @covers \App\Models\Status::getAll
     */
    public function testGetAll_selectAllStatus_return2DArray()
    {
        $all = Status::getAll();
        self::assertSame(3, count($all));
    }

    /**
     * @covers \App\Models\Status::getById
     */
    public function testGetById_GetOne_returnArray()
    {
        $status = Status::getById(1);
        self::assertSame(['id' => '1', 'name' => 'Building'], $status);
    }

    /**
     * @covers \App\Models\Status::selectMany
     */
    public function testSelectMany_SelectAllStatus_return2DArray()
    {
        $all = Status::selectMany("SELECT * FROM status", []);
        self::assertSame(3, count($all));
    }

    /**
     * @covers \App\Models\Status::selectOne
     */
    public function testSelect_SelectOneById_returnArray()
    {
        $status = Status::selectOne('SELECT * FROM Status WHERE id = :id', ['id' => 1]);
        self::assertSame(['id' => '1', 'name' => 'Building'], $status);
    }

    /**
     * @covers  \App\Models\Status::delete
     * @depends testGetById_GetOne_returnArray
     */
    public function testDelete_deleteById_statusDeleted()
    {
        Status::delete(3);
        $arrayStatus = Status::getById(3);
        self::assertSame(0, count($arrayStatus));
    }


    /**
     * @covers  \App\Models\Status::deleteWhere
     * @depends testGetById_GetOne_returnArray
     */
    public function testDeleteWhere_deleteById_statusDeleted()
    {
        Status::deleteWhere(['id' => 3]);
        $arrayStatus = Status::getById(3);
        self::assertSame(0, count($arrayStatus));
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
     * @covers  \App\Models\Status::update
     * @depends testGetById_GetOne_returnArray
     */
    public function testExecute_updateStatus_entryUpdated()
    {
        Status::update(['name' => 'Updated'], 1);
        $arrayStatus = Status::getById(1);
        self::assertSame('Updated', $arrayStatus['name']);
    }

}