<?php
namespace Point_Calc_Php\Core\Services\Database;

use PDO;
use PDOStatement;

abstract class Connection { // Context
    private static Config $config;
    protected static PDO $connection;

    public abstract static function connect(): PDO;
    public abstract static function disconnect(): void;
    public abstract function executeCommand(string | PDOStatement $command): bool;
    public abstract function getData(string | PDOStatement $command): array;

    public static function getConfig(?string $path) : Config {
        if (!isset(self::$config))
            self::$config = new Config($path) ?? new Config(null);
        return self::$config;
    }

    public static function getConnection() {
        return self::$connection ?? self::connect();
    }

    // Trying to implement some strategy

    private IDatabase $database;

    public function __construct(?IDatabase $database) {
        $this->database = $database;        
    }

    public function setDatabase(IDatabase $database) {
        $this->database = $database;
    }


}
?>