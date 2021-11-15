<?php

use App\Models\User;
use PHPUnit\Framework\TestCase;

include_once "./config/db.php";

class UserTest extends TestCase
{

    protected function setUp(): void
    {
        // TODO update db refresh mechanism
        $command = ' mysql --user="' . USER . '" --database="' . DB_NAME . '" --password="' . PWD . '" < "./database/testDataBase.sql"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\User::get
     */
    public function testGet_getFirstUser_returnObject()
    {
        $user = User::get(1);
        self::assertSame("User 1", $user->getName());
    }

    /**
     * @covers \App\Models\User::get
     */
    public function testGet_invalidId_returnNull()
    {
        $empty = User::get(10); // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\User::edit
     * @depends testGet_getFirstUser_returnObject
     */
    public function testEdit_editNameAttribute_nameChanged()
    {
        // Get existing User
        $user = User::get(2);
        $name = 'User edited';
        $user->setName($name);
        $user->edit();
        self::assertSame($name, $user->getName());
    }


    /**
     * @covers  \App\Models\User::remove
     * @depends testGet_getFirstUser_returnObject
     */
    public function testRemove_removeValidId_entryDeleted()
    {
        $user = User::get(5);
        $user->remove();
        $deleted = User::get(5);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\User::remove
     */
    public function testRemove_removeInvalidId_ThrowException()
    {
        $user = User::get(1);
        // Set up expectation
        self::expectException('PDOException');
        self::expectExceptionCode(23000);
        self::expectExceptionMessage('Integrity constraint violation');
        // Remove first User will throw and exception
        // because it is used as a foreign key
        $user->remove();
    }

    /**
     * @covers  \App\Models\User::create
     */
    public function testCreate_createUser_returnLastInsertId()
    {
        $user = new User();
        $name = 'New User';
        $user->setName($name);
        $id = $user->create();
        // id will be set as 4th record
        self::assertSame(6, $user->getId());
    }

    /**
     * @covers  \App\Models\User::toObject
     * @depends testGet_getFirstUser_returnObject
     */
    public function testToObject_toObjectFromArray_newObject()
    {
        $fromGet = User::get(1);
        $params = User::selectById(1);
        $fromToObject = User::toObject($params);
        self::assertEquals($fromGet, $fromToObject);
    }

}