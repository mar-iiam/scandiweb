<?php
namespace config;
use PDO;

abstract class DataBaseConnection {
    protected $pdo;

    public function __construct(string $host, string $dbname, string $user, string $password) {
        $dsn = $this->getDsn($host, $dbname);
        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
          
            throw new \Exception("Database connection error: " . $e->getMessage());
        }
    }

    abstract protected function getDsn(string $host, string $dbname): string;

    public function getPdo(): PDO {
        return $this->pdo;
    }
}