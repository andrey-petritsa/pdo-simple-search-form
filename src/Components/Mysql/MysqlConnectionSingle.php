<?php

namespace App\Components\Mysql;

use Dotenv\Dotenv;

class MysqlConnectionSingle
{
    private static $mysql_cursor;

    private function __construct()
    {
    }

    static public function getInstance()
    {
        if (!isset(self::$mysql_cursor)) {
            self::getAppEnvironmentVariables();
            self::$mysql_cursor = new \mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME'], $_ENV['DB_PORT']);
            if (self::$mysql_cursor->connect_error) {
                die("Connection failed: " . self::$mysql_cursor->connect_error);
            }
        }
        return self::$mysql_cursor;
    }

    private static function getAppEnvironmentVariables()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
}