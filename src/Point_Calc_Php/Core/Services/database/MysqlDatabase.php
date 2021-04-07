<?php
namespace Point_Calc_Php\Core\Services\Database;

use PDO, PDOException;

class MysqlDatabase extends Database implements IDatabase {
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

    public function __construct() {
        $this->config = new Config();
    }    
}
?>