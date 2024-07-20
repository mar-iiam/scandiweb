<?php

namespace config;


use PDO;

class MysqlDatabase extends DataBaseConnection{
    protected $pdo;

    public function __construct(string $host = '127.0.0.1', string $dbname = 'ProductTask', string $user = 'root', string $password = '') {
        parent::__construct($host, $dbname, $user, $password);
    }

    protected function getDsn(string $host, string $dbname): string {
        return "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    }
}

