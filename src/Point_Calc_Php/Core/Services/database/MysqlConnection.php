<?php
namespace Point_Calc_Php\Core\Services\Database;

use PDO;
use PDOException;
use phpDocumentor\Reflection\Types\Boolean;

class MysqlConnection extends Connection {
    private Config $config;
    private PDO $connection;

    public function connect(): void {
        try {
            $this->connection = new PDO(
                $this->config->getDbDriver() . 
                ":host=" . $this->config->getDbServer() . 
                ";dbname=" . $this->config->getDbDatabase() ,
                $this->config->getDbUserName() ,
                $this->config->getDbPassword()
            );
            $this->connected = true;
        } catch (PDOException $err) {
            die("Database connection failed");
        }
    }
    public function getConfig() : void {

    }
    public function executeCommand(string $command): void {

    }
    public function getData(string $command): array {
        return [];
    }
    public function __construct() {
        $this->config = new Config(null);
    }
}
?>