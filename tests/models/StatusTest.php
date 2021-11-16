<?php

use App\Models\Status;
use PHPUnit\Framework\TestCase;

include_once "./config/db.php";

class StatusTest extends TestCase
{

    protected function setUp(): void
    {
        // TODO update db refresh mechanism
        $command = ' mysql --user="' . USER . '" --database="' . DB_NAME . '" --password="' . PWD . '" < "./database/testDataBase.sql"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\Status::get
     */
    public function testGet_getFirstStatus_returnObject()
    {
        $status = Status::get(1);
        self::assertSame("Building", $status->getName());
    }

    /**
     * @covers \App\Models\Status::get
     */
    public function testGet_invalidId_returnNull()
    {
        $empty = Status::get(10); // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Status::edit
     * @depends testGet_getFirstStatus_returnObject
     */
    public function testEdit_editStatusAttribute_statusChanged()
    {
        // Get existing status
        $status = Status::get(2);
        $name = 'Status edited';
        $status->setName($name);
        $status->edit();
        self::assertSame($name, $status->getName());
    }

    /**
     * @covers  \App\Models\Status::edit
     * @depends testGet_getFirstStatus_returnObject
     */
    public function testEdit_editUsedStatusName_throwException()
    {
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');

        // Edit status with already used name will throw and exception
        $status = Status::get(2);
        $name = 'Building';             //Same as first
        $status->setName($name);
        $status->edit();
        self::assertSame($name, $status->getName());
    }


    /**
     * @covers  \App\Models\Status::remove
     * @depends testGet_getFirstStatus_returnObject
     */
    public function testRemove_removeValidId_entryDeleted()
    {
        $status = Status::get(2);
        $status->remove();
        $deleted = Status::get(2);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\Status::remove
     */
    public function testRemove_removeInvalidId_throwException()
    {
        $status = Status::get(1);
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');
        // Remove first status will throw and exception
        // because it is used as a foreign key
        $status->remove();
    }

    /**
     * @covers  \App\Models\Status::create
     */
    public function testCreate_createValidStatus_returnLastInsertId()
    {
        $status = new Status();
        $name = 'New Status';
        $status->setName($name);
        $id = $status->create();
        // id will be set as 4th record
        self::assertSame(4, $status->getId());
    }

    /**
     * @covers \App\Models\Status::create
     */
    public function testCreate_createUsedStatusName_returnFalse()
    {
        $status = new Status();
        $name = 'Building';             // already exist, all statuses must be unique
        $status->setName($name);
        $result = $status->create();
        self::assertFalse($result);
    }

    /**
     * @covers  \App\Models\Status::toObject
     * @depends testGet_getFirstStatus_returnObject
     */
    public function testToObject_toObjectFromArray_newObject()
    {
        $fromGet = Status::get(1);
        $params = Status::selectById(1);
        $fromToObject = Status::toObject($params);
        self::assertEquals($fromGet, $fromToObject);
    }

}