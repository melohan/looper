<?php

use App\Models\Type;
use PHPUnit\Framework\TestCase;

require_once 'config/DB.php';


class TypeTest extends TestCase
{

    protected function setUp(): void
    {
        // TODO update db refresh mechanism
        $command = ' mysql --user="' . USER . '" --database="' . DB_NAME . '" --password="' . PWD . '" < "./database/testDataBase.sql"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\Type::get
     */
    public function testGet_getFirstTest_returnObject()
    {
        $type = Type::get(1);
        self::assertSame("Single line text", $type->getName());
    }

    /**
     * @covers \App\Models\Type::get
     */
    public function testGet_invalidId_returnNull()
    {
        $empty = Type::get(10); // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Type::edit
     * @depends testGet_getFirstTest_returnObject
     */
    public function testEdit_editNameAttribute_nameChanged()
    {
        // Get existing type
        $type = Type::get(2);
        $name = 'Type edited';
        $type->setName($name);
        $type->edit();
        self::assertSame($name, $type->getName());
    }

    /**
     * @covers  \App\Models\Type::edit
     * @depends testGet_getFirstTest_returnObject
     */
    public function testEditThrowException()
    {
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');

        // Edit type with already used name will throw and exception
        $type = Type::get(2);
        $name = 'Single line text';             //Same as first
        $type->setName($name);
        $type->edit();
        self::assertSame($name, $type->getName());
    }


    /**
     * @covers  \App\Models\Type::remove
     * @depends testGet_getFirstTest_returnObject
     */
    public function testRemove_removeValidId_entryDeleted()
    {
        $type = Type::get(2);
        $type->remove();
        $deleted = Type::get(2);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\Type::remove
     */
    public function testRemove_removeInvalidId_ThrowException()
    {
        $type = Type::get(1);
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');
        // Remove first type will throw and exception
        // because it is used as a foreign key
        $type->remove();
    }

    /**
     * @covers  \App\Models\Type::create
     */
    public function testCreate_createValidType_returnLastInsertId()
    {
        $type = new Type();
        $name = 'New Type';
        $type->setName($name);
        $id = $type->create();
        // id will be set as 4th record
        self::assertSame(4, $type->getId());
    }

    /**
     * @covers \App\Models\Type::create
     */
    public function testCreate_createInvalidType_returnFalse()
    {
        $type = new Type();
        $name = 'Single line text';             // already exist, all types must be unique
        $type->setName($name);
        $result = $type->create();
        self::assertFalse($result);
    }

    /**
     * @covers  \App\Models\Type::toObject
     * @depends testGet_getFirstTest_returnObject
     */
    public function testToObject_toObjectFromArray_newObject()
    {
        $fromGet = Type::get(1);
        $params = Type::getById(1);
        $fromToObject = Type::toObject($params);
        self::assertEquals($fromGet, $fromToObject);
    }

}