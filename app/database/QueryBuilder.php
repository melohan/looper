<?php

namespace App\Database;

/**
 * Builds the sql queries to be executed.
 */
class QueryBuilder
{
    private string $query;

    /**
     * Initialize query
     */
    public function __construct()
    {
        $this->query = '';
    }

    /**
     * Concatenate
     * @param string $text
     * @param bool $start
     */
    private function add(string $text, bool $start = false)
    {
        if ($start === false)
            $this->query .= ' ';
        $this->query .= $text;
    }

    /**
     * Concatenate select, it selects all by default
     * @param array $column
     * @return $this
     */
    public function select(array $column = []): self
    {
        $this->add('SELECT', true);
        if (empty($column)) {
            $this->add('*');
        } else {
            $selection = implode(', ', array_map(function ($item) {
                return $item;
            }, $column));
            $this->add($selection);
        }
        return $this;
    }

    /**
     * Start query by SELECT COUNT(field)
     * @param string $field
     * @return $this
     */
    public function selectCount(string $field): self
    {
        $this->add("SELECT COUNT($field)", true);
        return $this;
    }

    /**
     * Concatenate "AS alias"
     * @param string $alias
     */
    public function as(string $alias):self
    {
        $this->add("AS $alias");
        return $this;
    }

    /**
     * Concatenate "FROM table"
     * @param string $table
     * @return $this
     */
    public function from(string $table): self
    {
        $this->add("FROM $table");
        return $this;
    }

    /**
     * Concatenate "where column operator"
     * @param string $column
     * @param string $operator
     * @return $this
     */
    public function where(string $column, string $operator): self
    {
        $this->add("WHERE $column $operator :$column");
        return $this;
    }

    /**
     * Concatenate "where column operator"
     * @param string $column
     * @param string $operator
     * @return $this
     */
    public function whereColumn(string $column, string $operator, string $other): self
    {
        $this->add("WHERE $column $operator :$other");
        return $this;
    }

    /**
     * Concatenate "and where column operator"
     * @param string $column
     * @param string $operator
     * @return $this
     */
    public function andWhere(string $column, string $operator): self
    {
        $this->add("AND $column $operator :$column");
        return $this;
    }

    /**
     * Concatenate where equal on multiple condition
     * @param array $condition
     * @return $this
     */
    public function whereEqual(array $condition): self
    {
        if (!empty($condition)) {
            $key = array_key_first($condition);
            $this->where($key, '=');
            unset($condition[$key]);
            $keys = array_keys($condition);
            $where = implode(' ', array_map(function ($item) {
                return 'AND ' . $item . ' = :' . $item;
            }, $keys));
            $this->add($where);
        }
        return $this;
    }

    /**
     * Concatenate Inner join on table lhs = rhs
     * @param string $table
     * @param string $lhs
     * @param string $rhs
     * @return $this
     */
    public function join(string $table, string $lhs, string $rhs): self
    {
        $this->add("INNER JOIN $table ON $lhs = $rhs");
        return $this;
    }

    /**
     * Order by column order
     * @param string $column
     * @param string $order
     * @return $this
     */
    public function orderBy(string $column, string $order): self
    {
        $this->add("ORDER BY $column $order");
        return $this;
    }

    /**
     * Create an insert query
     * @param string $table
     * @param array $params
     * @return \App\models\QueryBuilder
     */
    public function insert(string $table, array $params): self
    {
        $this->add('INSERT INTO ' . $table, true);
        $keys = array_keys($params);
        $insert = implode(', ', $keys);
        $values = implode(', ', array_map(function ($item) {
            return ' :' . $item;
        }, $keys));
        $this->add(" ($insert) VALUES ($values)");
        return $this;
    }

    /**
     * Create an update query
     * @param string $table
     * @param array $params
     * @param string $fieldWhere
     * @return \App\models\QueryBuilder
     */
    public function update(string $table, array $params, string $fieldWhere): self
    {
        $keys = array_keys($params);
        $commaSeparated = implode(', ', array_map(function ($item) {
            return $item . ' = :' . $item;
        }, $keys));
        $this->add("UPDATE $table SET $commaSeparated WHERE $fieldWhere = :$fieldWhere", true);
        return $this;
    }

    /**
     * Create a delete WHERE query
     * @param string $table
     * @param string $field
     */
    public function delete(string $table, string $field): self
    {
        $this->add("DELETE FROM $table WHERE $field = :$field", true);
        return $this;
    }

    /**
     * Delete in multiple where condition
     * @param $table
     * @param array $params
     */
    public function deleteWhere($table, array $params): self
    {
        if (count($params) > 0) {
            $firstKey = array_key_first($params);
            $this->add("DELETE FROM $table WHERE $firstKey = :$firstKey", true);
            unset($params[$firstKey]);
            $this->whereEqual($params);
        }
        return $this;
    }

    /**
     * Group by field
     * @param string $field
     * @return $this
     */
    public function groupBy(string $field): self
    {
        $this->add("GROUP BY $field");
        return $this;
    }

    /**
     * Add having field = :field
     * @param string $field
     * @return $this
     */
    public function having(string $field): self
    {
        $this->add("HAVING $field = :$field");
        return $this;
    }

    /**
     * Return builded query
     * @return string
     */
    public function build()
    {
        return $this->query;
    }


}