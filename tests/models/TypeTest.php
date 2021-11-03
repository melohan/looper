<?php

use App\Models\Type;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

class TypeTest extends TestCase
{

    protected function setUp(): void
    {
        // Re-execute SCRIPT before each test
        $command = ' mysql --user="' . TEST_USER . '" --database="' . TEST_DB_NAME . '" --password="' . TEST_PASSWORD . '" < "tests/models/config/' . TEST_SCRIPT . '"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\Type::get
     */
    public function testGet()
    {
        $type = Type::get(1);
        self::assertSame("Single line text", $type->getName());
    }

    /**
     * @covers \App\Models\Type::get
     */
    public function testGetNull()
    {
        $empty = Type::get(10); // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Type::edit
     * @depends testGet
     */
    public function testEdit()
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
     * @depends testGet
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
     * @depends testGet
     */
    public function testRemove()
    {
        $type = Type::get(2);
        $type->remove();
        $deleted = Type::get(2);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\Type::remove
     */
    public function testRemoveThrowException()
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
    public function testCreate()
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
    public function testCreateReturnFalse()
    {
        $type = new Type();
        $name = 'Single line text';             // already exist, all types must be unique
        $type->setName($name);
        $result = $type->create();
        self::assertFalse($result);
    }

}