<?php
namespace Point_Calc_Php\Core\Services\Database;

use Exception;
use InvalidArgumentException;

class Config {
    private string $dbServer;
    private string $dbPort;
    private string $dbUserName;
    private string $dbPassword;
    private string $dbDatabase;
    private string $dbDriver;

    public function __construct(?string $file) {
        $_file = $file ?? 'config.php';
        if (file_exists($_file)) {
            include_once($_file);
            $this->dbServer = $config['server'];
            $this->dbPort = $config['port'];
            $this->dbUserName = $config['user'];
            $this->dbPassword = $config['password'];
            $this->dbDriver = $config['driver'];
        } else {
            $this->dbDriver = 'cookie';
            throw new Exception("Database configuration file not found. Check if \"".$file."\" exists and it is on correct place. Using cookies instead.");
        }        
    }

    /** Getters without setters because these configurations is read-only runtime. */

    private function __set($name, $value) {}

    /** Class methods are only being accessed via public getters */

    public function __get($field) {
        if (!property_exists($this, $field)) {
            throw new InvalidArgumentException("The field ".$field." does not exist.");
        }

        $getter = "get".ucfirst($field);
        if (method_exists($this, $getter) && is_callable(array($this, $getter))) {
            $this->$getter();
        } else {
            throw new InvalidArgumentException("The field ".$field." cannot be accessed from this scope. Use the getter.");
        }
    }

    public function getDbServer()   { return $this->dbServer; }
    public function getDbPort()     { return $this->dbPort; }
    public function getDbUserName() { return $this->dbUserName; }
    public function getDbPassword() { return $this->dbPassword; }
    public function getDbDatabase() { return $this->dbDatabase; }
    public function getDbDriver()   { return $this->dbDriver; }
}