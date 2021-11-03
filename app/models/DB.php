<?php

namespace App\Models;

include_once 'config/db.php';

use PDO;
use PDOException;

class DB
{

    /**
     * Return initilized pdo object or false if an error has occured.
     * @return PDO
     * @throws PDOException
     */
    static function getPDO(): PDO
    {
        $pdo = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DB_NAME, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * Execute the query with the passed parameters
     * @param $query
     * @param array $params
     * @throws PDOException
     */
    static function execute($query, array $params)
    {
        $db = self::getPDO();
        $stmt = $db->prepare($query);
        $stmt->execute($params);
    }

    /**
     * Select single or many entries depending on multiple statement or return false if an error has occured.
     * @param $query
     * @param array $params
     * @param $multiple
     * @return array|false|mixed
     * @throws PDOException
     */
    static function select($query, array $params, $multiple)
    {
        $db = self::getPDO();
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $result = $multiple == true ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
        return $result === false ? [] : $result;
    }

    /**
     * Select many entries or return false if an error has occured.
     * @param $query
     * @param array $params
     * @return array|false|mixed
     * @throws PDOException
     */
    static function selectMany($query, array $params): array
    {
        return self::select($query, $params, true);
    }


    /**
     * Select one entry or return false if an error has occured.
     * @param $query
     * @param array $params
     * @return array
     */
    static function selectOne($query, array $params): array
    {
        return self::select($query, $params, false);
    }

    /**
     * Insert an entry and return last insert id
     * @param $query
     * @param array $params
     * @return int
     * @throws PDOException
     */
    static function insert($query, array $params): int
    {
        $db = self::getPDO();
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        return $db->lastInsertId();
    }

}