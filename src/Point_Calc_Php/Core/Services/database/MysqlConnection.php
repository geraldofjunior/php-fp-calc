<?php
namespace Point_Calc_Php\Core\Services\Database;

use PDO;
use PDOException;
use PDOStatement;
use phpDocumentor\Reflection\Types\Boolean;

class MysqlConnection extends Connection {
    private static PDO $connection;

    public static function connect(): PDO {
        $config = parent::getConfig(null);
        try {
            self::$connection = new PDO(
                $config->getDbDriver() . 
                ":host="   . $config->getDbServer() . 
                ";dbname=" . $config->getDbDatabase() ,
                $config->getDbUserName() ,
                $config->getDbPassword()
            );
        } catch (PDOException $err) {
            die("Database connection failed. Error: " . $err->getMessage());
        }
        return self::$connection;
    }

    public static function disconnect(): void {
        self::$connection->disconnect;
    }

    public function executeCommand(string | PDOStatement $command): bool {
        $_command = $command;
        if (!($command instanceof PDOStatement)) {
            $_command = self::$connection->prepare($command);
        }
        return $_command->execute();

    }
    public function getData(string | PDOStatement $command): array {
        $_command = $command;
        if (!($command instanceof PDOStatement)) {
            $_command = self::$connection->prepare($command);
        }
        return $_command->fetch();
    }
    public function __construct() {
        $this->config = new Config(null);
    }
}
?>