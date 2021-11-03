<?php

use App\Models\User;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

class UserTest extends TestCase
{

    protected function setUp(): void
    {
        // Re-execute SCRIPT before each test
        $command = ' mysql --user="' . TEST_USER . '" --database="' . TEST_DB_NAME . '" --password="' . TEST_PASSWORD . '" < "tests/models/config/' . TEST_SCRIPT . '"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\User::get
     */
    public function testGet()
    {
        $user = User::get(1);
        self::assertSame("User 1", $user->getName());
    }

    /**
     * @covers \App\Models\User::get
     */
    public function testGetNull()
    {
        $empty = User::get(10); // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\User::edit
     * @depends testGet
     */
    public function testEdit()
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
     * @depends testGet
     */
    public function testRemove()
    {
        $user = User::get(5);
        $user->remove();
        $deleted = User::get(5);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\User::remove
     */
    public function testRemoveThrowException()
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
    public function testCreate()
    {
        $user = new User();
        $name = 'New User';
        $user->setName($name);
        $id = $user->create();
        // id will be set as 4th record
        self::assertSame(6, $user->getId());
    }

}