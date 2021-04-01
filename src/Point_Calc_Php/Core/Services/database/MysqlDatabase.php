<?php
namespace Point_Calc_Php\Core\Services\Database;

use PDO;
use PDOException;
use PDOStatement;

class MysqlDatabase extends Database implements IDatabase {
    private PDO $connection;
    private Config $config;

    public function connect() : IDatabase {
        $config = $this->config;
        try {
            $this->connection = new PDO(
                $config->getDbDriver() . 
                ":host="   . $config->getDbServer() . 
                ";dbname=" . $config->getDbDatabase() ,
                $config->getDbUserName() ,
                $config->getDbPassword()
            );
        } catch (PDOException $err) {
            die("Database connection failed. Error: " . $err->getMessage());
        }
        return $this;
    }

    public function disconnect(): void {
        $this->connection = null;
    }

    public function __construct() {
        $this->config = new Config(null);
    }

    
}
?>