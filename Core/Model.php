<?php

namespace Core;

use Core\Database;

abstract class Model extends Database
{
    protected string $table;
    protected static array $allowed_fields;

    public function __construct()
    {
        parent::__construct();

        if (!$this->table || !ctype_alnum(str_replace(['_', '-'], '', $this->table))) {
            throw new \Exception("Invalid table name.");
        }
    }

    private function validateColumn(string $column)
    {
        if (!in_array($column, self::$allowed_fields, true)) {
            throw new \Exception("Invalid column: $column.");
        }
    }

    /**
     * Retrieve all records from the table.
     *
     * @return array The results as an associative array.
     */
    public function all()
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            return $this->query($sql);
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Find a record by its ID.
     *
     * @param int $id The ID of the record.
     * @return array|null The record as an associative array, or null if not found.
     */
    public function find(int $id): array|null
    {
        return $this->findBy('id', $id);
    }

    /**
     * Find a record by its ID or throw an exception if not found.
     *
     * @param int $id The ID of the record.
     * @return array The record as an associative array.
     * @throws \Exception If the record with the given ID is not found.
     */
    public function findOrFail(int $id)
    {
        $record = $this->find($id);

        if ($record === null) {
            throw new \Exception("Record with ID $id not found.");
        }

        return $record;
    }

    /**
     * Find a record by a specific column.
     *
     * @param string $column The column to search by.
     * @param mixed $value The value to search for.
     * @return array|null The record as an associative array, or null if not found.
     */
    public function findBy(string $column, $value)
    {
        $this->validateColumn($column);

        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
            $result = $this->query($sql, ['value' => $value]);
            return $result ? $result[0] : null;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Retrieve the first record from the table.
     *
     * @return array|null The first record as an associative array, or null if no record exists.
     */
    public function first()
    {
        try {
            return $this->query("SELECT * FROM {$this->table} LIMIT 1")[0] ?? null;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Save a new record to the database.
     *
     * @param array $data The data to insert.
     * @return bool True on success, false on failure.
     */
    public function save(array $data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($data)));

            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $this->query($sql, $data);

            return true;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Update a record by its ID.
     *
     * @param int $id The ID of the record to update.
     * @param array $data The data to update.
     * @return bool True on success, false on failure.
     */
    public function update(int $id, array $data)
    {
        unset($data['id']);

        foreach (array_keys($data) as $column) {
            $this->validateColumn($column);
        }

        try {
            $columns = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($data)));
            $sql = "UPDATE {$this->table} SET $columns WHERE id = :id";

            $data['id'] = $id;
            $this->query($sql, $data);

            return true;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Delete a record by its ID.
     *
     * @param int $id The ID of the record.
     * @return bool True on success, false on failure.
     */
    public function delete(int $id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $this->query($sql, ['id' => $id]);

            return true;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
