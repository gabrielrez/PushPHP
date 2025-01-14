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

        if (!self::$table || !ctype_alnum(str_replace(['_', '-'], '', self::$table))) {
            throw new \Exception("Invalid table name.");
        }
    }

    private static function validateColumn(string $column)
    {
        if (!in_array($column, self::$allowed_fields, true)) {
            throw new \Exception("Invalid column: $column.");
        }
    }

    // CRUD methods
}
