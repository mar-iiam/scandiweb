<?php

namespace config;

// Use the correct PDO namespace
use PDO;

class MysqlDatabase extends dataBaseConnection{
    protected $pdo;

    public function __construct(string $host = '127.0.0.1', string $dbname = 'ProductTask', string $user = 'root', string $password = '') {
        parent::__construct($host, $dbname, $user, $password);
    }

    protected function getDsn(string $host, string $dbname): string {
        return "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    }
}



/*
$host = '127.0.0.1';  // or '127.0.0.1'
$port = '3306';       // default MySQL port
$dbname = 'ProductTask';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
*/

