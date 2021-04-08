<?php
namespace Point_Calc_Php\Core\Services\Database;

use Exception;

abstract class Connection { // Context
    private static Config $config;
    protected static IDatabase $connection;

    public static function connect() : IDatabase {
        if (isset(self::$connection)) {
            return self::$connection;
        }

        if (!isset(self::$config)) {
            self::getConfig();
        }

        try {
            $class = ucfirst( strtolower( self::$config->getDbDriver() ) ) . "Database";
            $db = new $class();

            $db->connect();

            self::$connection = $db;
        } catch (Exception $e) {
            // TODO: Make a proper way to treat errors
            die( "Error at file " . $e->getFile() . ", line " . $e->getLine() . ": " . $e->getMessage() );
        }

        return self::$connection;
    }

    public static function getConfig(?string $path = null) : Config {
        if (!isset(self::$config))
            self::$config = new Config($path) ?? new Config(null);
        return self::$config;
    }

    public static function getConnection() : IDatabase {
        return self::$connection ?? self::connect();
    }
}