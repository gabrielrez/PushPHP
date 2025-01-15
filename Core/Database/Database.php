<?php

namespace Core\Database;

use InvalidArgumentException;
use PDO;
use PDOException;
use PDOStatement;

/* ~~~ Database Class 🎲 ~~~  */

abstract class Database
{
    private static ?PDO $conn = null;
    protected array $config;
    protected PDO $db;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../config/config.php';

        if (!isset($this->config['database'])) {
            throw new InvalidArgumentException("Database configuration not found.");
        }

        $this->db = self::getConn($this->config['database']);
    }

    /**
     * Retrieves the Singleton PDO connection instance.
     *
     * Creates a new connection if none exists.
     *
     * @param array $config The database configuration array.
     * @param string|null $username Optional username for the database connection.
     * @param string|null $password Optional password for the database connection.
     * @return PDO The PDO connection instance.
     * @throws InvalidArgumentException If essential configuration values are missing.
     * @throws PDOException If the connection cannot be established.
     */
    protected static function getConn(array $config, ?string $username = null, ?string $password = null): PDO
    {
        if (self::$conn === null) {
            if (empty($config['host']) || empty($config['dbname'])) {
                throw new InvalidArgumentException("The database configuration must include 'host' and 'dbname'.");
            }

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;port=%s;charset=%s',
                $config['host'],
                $config['dbname'],
                $config['port'] ?? 3306,
                $config['charset'] ?? 'utf8mb4'
            );

            $username = $username ?? $config['username'] ?? 'root';
            $password = $password ?? $config['password'] ?? '';

            try {
                self::$conn = new PDO($dsn, $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                throw new PDOException(
                    sprintf("Database connection failed: [%s] %s", $dsn, $e->getMessage())
                );
            }
        }

        return self::$conn;
    }

    /**
     * Executes a database query with optional parameters.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters to bind to the query.
     * @return PDOStatement The prepared statement.
     * @throws PDOException If the query fails.
     */
    public static function query(string $sql, array $params = []): PDOStatement
    {
        $conn = self::$conn;

        if (!$conn) {
            throw new PDOException("No active database connection.");
        }

        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException(
                sprintf("Query failed: [%s] %s", $sql, $e->getMessage())
            );
        }
    }

    /**
     * Gets the ID of the last record inserted into the database.
     *
     * @return int The ID of the last record inserted.
     * @throws \Exception If there is no active connection or an error occurs.
     */
    public static function lastInsertId(): int
    {
        if (!self::$conn) {
            throw new \Exception("No active database connection.");
        }

        try {
            return (int) self::$conn->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to retrieve last insert ID: " . $e->getMessage());
        }
    }
}
