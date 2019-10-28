<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.10.2019
 * Time: 11:15
 */

namespace domain;

use \PDO;

class Database
{
    //These constants should be in some kind of local file (config-local for example)
    const HOST = '127.0.0.1';
    const DATABASE_NAME = 'user_track';
    const USERNAME = 'root';
    const PASSWORD = '';

    private $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DATABASE_NAME . ';charset=utf8';
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->pdo = new PDO($dsn, self::USERNAME, self::PASSWORD, $options);
    }

    /**
     * Just prepare sql query
     * @param string $query
     * @param array $data
     * @return bool|\PDOStatement
     */
    private function prepare(string $query, array $data): \PDOStatement
    {
        $stmt = $this->pdo->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        return $stmt;
    }

    /**
     * @param string $query
     * @param array $data
     * @return int
     */
    public function execute(string $query, array $data): int
    {
        $stmt = $this->prepare($query, $data);
        return $stmt->execute();
    }

    /**
     * @param string $query
     * @param array $data
     * @return bool
     */
    public function checkExistRow(string $query, array $data): bool
    {
        $stmt = $this->prepare($query, $data);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result > 0;
    }
}