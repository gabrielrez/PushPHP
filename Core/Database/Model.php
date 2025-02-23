<?php

namespace Core\Database;

use Core\Database\Database;

abstract class Model extends Database
{
    protected static string $table;
    protected static array $allowed_fields;

    public function __construct()
    {
        parent::__construct();

        if (!static::$table || !ctype_alnum(str_replace(['_', '-'], '', static::$table))) {
            throw new \Exception("Invalid table name.");
        }
    }

    private static function validateColumn(string $column)
    {
        if (!in_array($column, static::$allowed_fields, true)) {
            throw new \Exception("Invalid column: $column.");
        }
    }

    /**
     * Get all records from the table.
     *
     * @return array
     * @throws \Exception
     */
    public static function all(): array
    {
        $query = "SELECT * FROM `" . static::$table . "`";
        return static::query($query)->fetchAll();
    }

    /**
     * Find a record by its primary key.
     *
     * @param int|string $id
     * @return array|null
     * @throws \Exception
     */
    public static function find(int|string $id): ?array
    {
        $query = "SELECT * FROM `" . static::$table . "` WHERE id = :id LIMIT 1";
        $stmt = static::query($query, ['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Insert a new record into the table.
     *
     * @param array $data
     * @return int The ID of the newly created record.
     * @throws \Exception
     */
    public static function create(array $data): int
    {
        $fields = array_keys($data);

        foreach ($fields as $field) {
            static::validateColumn($field);
        }

        $columns = implode(", ", array_map(fn($col) => "`$col`", $fields));
        $placeholders = implode(", ", array_map(fn($col) => ":$col", $fields));

        $query = "INSERT INTO `" . static::$table . "` ($columns) VALUES ($placeholders)";
        static::query($query, $data);

        return static::lastInsertId();
    }

    /**
     * Update an existing record by its primary key.
     *
     * @param int|string $id
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public static function update(int|string $id, array $data): bool
    {
        $fields = array_keys($data);

        foreach ($fields as $field) {
            static::validateColumn($field);
        }

        $assignments = implode(", ", array_map(fn($col) => "`$col` = :$col", $fields));
        $data['id'] = $id;

        $query = "UPDATE `" . static::$table . "` SET $assignments WHERE id = :id";
        return static::query($query, $data)->rowCount() > 0;
    }

    /**
     * Delete a record by its primary key.
     *
     * @param int|string $id
     * @return bool
     * @throws \Exception
     */
    public static function delete(int|string $id): bool
    {
        $query = "DELETE FROM `" . static::$table . "` WHERE id = :id";
        $stmt = static::query($query, ['id' => $id]);

        if ($stmt->rowCount() === 0) {
            throw new \Exception("Record not found.");
        }

        return true;
    }

    /**
     * Get the first record that matches the criteria or fail.
     *
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public static function firstOrFail(array $criteria): array
    {
        $conditions = implode(" AND ", array_map(fn($col) => "`$col` = :$col", array_keys($criteria)));
        $query = "SELECT * FROM `" . static::$table . "` WHERE $conditions LIMIT 1";

        $stmt = static::query($query, $criteria);
        $record = $stmt->fetch();

        if (!$record) {
            throw new \Exception("Record not found.");
        }

        return $record;
    }

    /**
     * Get the first record that matches the criteria.
     *
     * @param array $criteria
     * @return array|null
     * @throws \Exception
     */
    public static function first(array $criteria): ?array
    {
        $conditions = implode(" AND ", array_map(fn($col) => "`$col` = :$col", array_keys($criteria)));
        $query = "SELECT * FROM `" . static::$table . "` WHERE $conditions LIMIT 1";

        $stmt = static::query($query, $criteria);
        return $stmt->fetch() ?: null;
    }

    /**
     * Get records matching the specified criteria.
     *
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public static function where(array $criteria): array
    {
        $conditions = implode(" AND ", array_map(fn($col) => "`$col` = :$col", array_keys($criteria)));
        $query = "SELECT * FROM `" . static::$table . "` WHERE $conditions";

        return static::query($query, $criteria)->fetchAll();
    }
}
