<?php

namespace App\Models;

use App\Database\DB;
use App\Database\QueryBuilder;

abstract class Model
{
    /**
     * Get table name from childrens name
     * @return string
     */
    static private function getTable()
    {
        $name = strtolower((new \ReflectionClass(get_called_class()))->getShortName());
        return preg_match('/.+(s)$/', $name) ? $name : $name . 's';
    }

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
     * @throws \PDOException if there is an integrity constraint
     */
    abstract public function remove(): void;

    /**
     * Create db record from object
     * @return int|false
     * @throws \PDOException if database set UNIQUE fields
     */
    abstract public function create(): int|false;

    /**
     * Convert associative array to object
     * @param array $params
     * @return object|null
     */
    abstract public static function toObject(array $params): object|null;

    /**
     * Convert array of associative arrays to objects
     * @param array $params
     * @return array
     */
    abstract public static function toObjectMany(array $params): array;


    /**
     * Get all from table
     * @return array|false|mixed
     */
    public static function getAll()
    {
        $q = new QueryBuilder();
        $query = $q->select()->from(self::getTable())->build();
        return DB::selectMany($query, []);
    }

    /**
     * Get all by id
     * @param int $id
     * @return array
     */
    public static function getById(int $id)
    {
        $q = new QueryBuilder();
        $query = $q->select()->from(self::getTable())->where('id', '=')->build();
        return DB::selectOne($query, ['id' => $id]);
    }

    /**
     * Select many
     * @param string $query
     * @param array $params
     * @return array|false|mixed
     */
    public static function selectMany(string $query, array $params)
    {
        return DB::selectMany($query, $params);
    }

    /**
     * Select one
     * @param string $query
     * @param array $params
     * @return array
     */
    public static function selectOne(string $query, array $params)
    {
        return DB::selectOne($query, $params);
    }

    /**
     * Delete by id
     * @param $id
     * @throws \PDOException
     */
    public static function delete($id)
    {
        $q = new QueryBuilder();
        $query = $q->delete(self::getTable(), 'id')->build();
        db::execute($query, ['id' => $id]);
    }

    /**
     * DeleteWhere multiple
     * @param $params
     * @throws \PDOException
     */
    public static function deleteWhere($params)
    {
        $q = new QueryBuilder();
        $query = $q->deleteWhere(self::getTable(), $params)->build();
        db::execute($query, $params);
    }

    /**
     * Insert into database
     * @param array $params
     * @return int
     * @throws \PDOException
     */
    public static function insert(array $params): int|false
    {
        $columns = $params;//array_keys($params);
        $q = new QueryBuilder();
        $query = $q->insert(self::getTable(), $columns)->build();
        return db::insert($query, $params);
    }

    /**
     * Update records
     * @param $query
     * @param $params
     * @param $ID
     * @throws \PDOException
     */
    public static function update(array $params, int $id): void
    {
        $q = new QueryBuilder();
        $query = $q->update(self::getTable(), $params, 'id')->build();
        $params['id'] = $id;
        db::execute($query, $params);
    }

    /**
     * Check if an entry exist by his id
     * @param int $id
     * @return bool
     */
    public static function exist(int $id): bool
    {
        return count(self::getById($id)) > 0;
    }

}