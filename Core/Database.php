<?php

namespace Core;

use PDO;
use PDOException;

/* ~~~ Database Class 🎲 ~~~  */

abstract class Database
{
    private static $conn;
    protected $config;
    protected $db;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../config/config.php';
        $this->db = $this->getConn($this->config['database']);
    }

    /**
     * Gets the database connection instance.
     *
     * @param array $config The database configuration array.
     * @param string|null $username Optional username for the database connection.
     * @param string|null $password Optional password for the database connection.
     * @return PDO The PDO instance representing the connection to the database.
     * @throws PDOException If the connection fails.
     */
    protected static function getConn(array $config, string $username = null, string $password = null): PDO
    {
        if (!isset(self::$conn)) {
            $dsn = 'mysql:' . http_build_query($config, '', ';');

            $username = $username ?? $config['username'] ?? 'root';
            $password = $password ?? $config['password'] ?? '';

            try {
                self::$conn = new PDO($dsn, $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                throw new PDOException("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$conn;
    }

    /**
     * Executes a SQL query and returns the results.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters to bind to the query.
     * @return array The results of the query as an associative array.
     */
    public function query(string $sql, array $params = [])
    {
        try {
            $stmt = self::$conn->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Query execution failed: " . $e->getMessage());
        }
    }
}
