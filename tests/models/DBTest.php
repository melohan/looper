<?php

use App\Models\DB;
use PHPUnit\Framework\TestCase;

include_once "./config/db.php";

class DBTest extends TestCase
{

    protected function setUp(): void
    {
        // TODO update db refresh mechanism
        $command = ' mysql --user="' . USER . '" --database="' . DB_NAME . '" --password="' . PWD . '" < "./database/testDataBase.sql"';
        shell_exec($command);
    }

    /**
     * @covers  DB::execute
     * @depends testSelectOne_selectOneUser_returnArray
     */
    public function testExecute_executeDeleteQuery_noReturn()
    {
        DB::execute("DELETE FROM Status WHERE id = :id", ['id' => 3]);
        $result = DB::selectOne("SELECT * FROM Status WHERE id = :id", ['id' => 3]);
        self::assertSame(0, count($result));
    }

    /**
     * @covers DB::select
     */
    public function testSelectMultiple_selectAllTypes_return2DArray()
    {
        $result = DB::select("SELECT * FROM Types", [], true);
        self::assertSame(3, count($result));
    }

    /**
     * @covers DB::select
     */
    public function testSelect_selectOneUser_returnArray()
    {
        $result = DB::select("SELECT * FROM Users WHERE id = :id", ['id' => 1], false);
        self::assertSame(['id' => '1', 'name' => 'User 1'], $result);
    }

    /**
     * @covers DB::selectMany
     */
    public function testSelectMany_selectManyUsers_return2DArray()
    {
        $result = DB::selectMany("SELECT * FROM Users", []);
        self::assertSame(5, count($result));
    }

    /**
     * @covers DB::selectOne
     */
    public function testSelectOne_selectOneUser_returnArray()
    {
        $result = DB::selectOne("SELECT * FROM Users WHERE name = :name", ['name' => 'User 3']);
        self::assertSame(['id' => '3', 'name' => 'User 3'], $result);
    }

    /**
     * @covers DB::insert
     */
    public function testInsert_insertTypes_returnInsertedId()
    {
        $result = DB::insert("INSERT INTO Types (name) VALUES (:name)", ['name' => 'New Type']);
        self::assertSame(4, $result);
    }


}