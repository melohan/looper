<?php

use App\Models\Status;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

class StatusTest extends TestCase
{

    protected function setUp(): void
    {
        // Re-execute SCRIPT before each test
        $command = ' mysql --user="' . TEST_USER . '" --database="' . TEST_DB_NAME . '" --password="' . TEST_PASSWORD . '" < "tests/models/config/' . TEST_SCRIPT . '"';
        shell_exec($command);
    }

    /**
     * @covers \App\Models\Status::get
     */
    public function testGet()
    {
        $status = Status::get(1);
        self::assertSame("Building", $status->getName());
    }

    /**
     * @covers \App\Models\Status::get
     */
    public function testGetNull()
    {
        $empty = Status::get(10); // id = 10 doesn't exist must return null
        self::assertNull($empty);
    }

    /**
     * @covers  \App\Models\Status::edit
     * @depends testGet
     */
    public function testEdit()
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
     * @depends testGet
     */
    public function testEditThrowException()
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
     * @depends testGet
     */
    public function testRemove()
    {
        $status = Status::get(2);
        $status->remove();
        $deleted = Status::get(2);
        self::assertNull($deleted);
    }

    /**
     * @covers \App\Models\Status::remove
     */
    public function testRemoveThrowException()
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
    public function testCreate()
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
    public function testCreateReturnFalse()
    {
        $status = new Status();
        $name = 'Building';             // already exist, all statuses must be unique
        $status->setName($name);
        $result = $status->create();
        self::assertFalse($result);
    }


}