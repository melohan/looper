<?php

use App\Models\DB;
use PHPUnit\Framework\TestCase;

include_once 'tests/models/config/db.php';

class DBTest extends TestCase
{

    protected function setUp(): void
    {
        // Re-execute SCRIPT before each test
        $command = ' mysql --user="' . TEST_USER . '" --database="' . TEST_DB_NAME . '" --password="' . TEST_PASSWORD . '" < "tests/models/config/' . TEST_SCRIPT . '"';
        shell_exec($command);
    }

    /**
     * @covers  DB::execute
     * @depends testSelectOne
     */
    public function testExecute()
    {
        DB::execute("DELETE FROM Status WHERE id = :id", ['id' => 3]);
        $result = DB::selectOne("SELECT * FROM Status WHERE id = :id", ['id' => 3]);
        self::assertSame(0, count($result));
    }

    /**
     * @covers DB::select
     */
    public function testSelectMultipleTrue()
    {
        $result = DB::select("SELECT * FROM Types", [], true);
        self::assertSame(3, count($result));
    }

    /**
     * @covers DB::select
     */
    public function testSelectMultipleFalse()
    {
        $result = DB::select("SELECT * FROM Users WHERE id = :id", ['id' => 1], false);
        self::assertSame(['id' => '1', 'name' => 'User 1'], $result);
    }

    /**
     * @covers DB::selectMany
     */
    public function testSelectMany()
    {
        $result = DB::selectMany("SELECT * FROM Users", []);
        self::assertSame(5, count($result));
    }

    /**
     * @covers DB::selectOne
     */
    public function testSelectOne()
    {
        $result = DB::selectOne("SELECT * FROM Users WHERE name = :name", ['name' => 'User 3']);
        self::assertSame(['id' => '3', 'name' => 'User 3'], $result);
    }

    /**
     * @covers DB::insert
     */
    public function testInsert()
    {
        $result = DB::insert("INSERT INTO Types (name) VALUES (:name)", ['name' => 'New Type']);
        self::assertSame(4, $result);
    }


}