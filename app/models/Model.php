<?php

namespace App\Models;

use PDOException;

abstract class Model
{

    /**
     * Return an object by his id
     * @param int $id
     * @return object|null
     */
    abstract static public function get(int $id): object|null;

    /**
     * Update db record from object
     */
    abstract public function edit(): void;

    /**
     * Remove db record from object
     */
    abstract public function remove(): void;

    /**
     * Create db record from object
     * @return int|false
     */
    abstract public function create(): int|false;



    /**
     * Get table name from childrens name
     * @return string
     */
    static private function getTable()
    {
        $name = strtolower((new \ReflectionClass(get_called_class()))->getShortName());
        return preg_match('/.+(s)$/', $name) ? $name : $name . 's';
    }

    /**     SELECT METHODS     **/

    /**
     * Select and return array of associative array
     * @param $query
     * @param $params
     * @return array|false|mixed
     */
    static function select(string $query, array $params)
    {
        return db::selectMany($query, $params);
    }

    /**
     * Select all records
     * @return array
     */
    static public function selectAll(): array
    {
        return db::selectMany("SELECT * FROM " . self::getTable(), []);
    }

    /**
     * Get record by Id
     * @param $id
     * @return array|false|mixed
     */
    static public function selectById(int $id):array
    {
        $res = db::selectOne("SELECT * FROM " . self::getTable() . " WHERE id = :id", ['id' => $id]);
        return $res === false ? [] : $res;
    }

    /**
     * Check if an entry exist by his id
     * @param int $id
     * @return bool
     */
    public static function exist(int $id): bool
    {
        return count(self::selectById($id))>0;
    }

    /**
     * Select one record where field is equal to $value
     * @param string $field
     * @param $value
     * @return array
     */
    static public function selectWhere(string $field, $value): array
    {
        $query = "SELECT * FROM " . self::getTable() . " WHERE " . $field . " = :" . $field;
        return db::selectOne($query, [$field => $value]);
    }  
    
    /**
    * Select many records where field is equal to $value
    * @param string $field
    * @param $value
    * @return array
    */
   static public function selectManyWhere(string $field, $value): array
   {
       $query = "SELECT * FROM " . self::getTable() . " WHERE " . $field . " = :" . $field;
       return db::selectMany($query, [$field => $value]);
   }

    /**
     * Delete record by id
     * @param int $id
     * @return false|void
     * @throws PDOException
     */
    static public function delete(int $id)
    {
        try {
            db::execute("DELETE FROM " . self::getTable() . " WHERE id = :id", ['id' => $id]);
        } catch (PDOException $e) {
            // foreign key constraint
            if ($e->getCode() == 1005)
                return false;
            throw $e;
        }
    }

    /**
     * Execute sql command
     * @param $query
     * @param $params
     */
    static function execute(string $query, array $params)
    {
        db::execute($query, $params);
    }


    /**
     * Insert data with associative array
     * @param array $params
     * @return false|int
     * @throws PDOException
     */
    static function insert(array $params): int|false
    {
        $keys = array_keys($params);
        $insert = implode(', ', $keys);
        $values = implode(', ', array_map(function ($item) {
            return ' :' . $item;
        }, $keys));
        try {
            return db::insert("INSERT INTO " . self::getTable() . " ($insert) VALUES ($values)", $params);
        } catch (PDOException $e) {
            // integrity constraint violation
            if ($e->getCode() == 23000)
                return false;
            throw $e;
        }
    }

    /**
     * Update records
     * @param int $id
     * @param array $params
     */
    static function update(int $id, array $params): void
    {
        $keys = array_keys($params);
        $commaSeparated = implode(', ', array_map(function ($item) {
            return $item . ' = :' . $item;
        }, $keys));
        $params['id'] = $id;
        db::execute("UPDATE " . self::getTable() . " SET $commaSeparated WHERE id = :id", $params);
    }


}