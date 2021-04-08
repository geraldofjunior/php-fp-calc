<?php
namespace Point_Calc_Php\Core\Services\Database;

use InvalidArgumentException;

class Config {
    private string $dbServer;
    private string $dbPort;
    private string $dbUserName;
    private string $dbPassword;
    private string $dbDatabase;
    private string $dbDriver;

    public function __construct(?string $file = null) {
        $this->readIniFile($file);
    }

    public function readIniFile(?string $file) {
        $_file = $file ?? 'db.ini';
        if (file_exists($_file)) {
            $config = parse_ini_file($_file);

            $this->dbServer   = $config['database']['server'];
            $this->dbPort     = $config['database']['port'];
            $this->dbUserName = $config['database']['user'];
            $this->dbPassword = $config['database']['password'];
            $this->dbDriver   = $config['database']['driver'];
            $this->dbDatabase = $config['database']['schema'];
        } else {
            $this->dbDriver = 'cookie';
            throw new InvalidArgumentException("Database configuration file not found. Check if \"".$file."\" exists and it is on correct place. Using cookies instead.");
        }
    }

    /** Getters without setters because these configurations is read-only runtime.
     */
    public function __set(string $name, mixed $value) {
        // Does nothing. Really. The configs is read-only
    }

    /** Class methods are only being accessed via public getters
     * @param $field
     */
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

    public function getDbServer()   : string { return $this->dbServer; }
    public function getDbPort()     : string { return $this->dbPort; }
    public function getDbUserName() : string { return $this->dbUserName; }
    public function getDbPassword() : string { return $this->dbPassword; }
    public function getDbDatabase() : string { return $this->dbDatabase; }
    public function getDbDriver()   : string { return $this->dbDriver; }
}