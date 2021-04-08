<?php
namespace Point_Calc_Php\Enums;

/**
 * This class provides some functionality for Enum classes on PHP
 * 
 * @author Brian Cline
 * @source https://stackoverflow.com/questions/254514/enumerations-on-php/254543#254543
 */

use ReflectionClass, Exception;

abstract class BasicEnum {
    private static array $constCacheArray = [];

    private static function getConstants() {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            try {
                $reflect = new ReflectionClass($calledClass);
                self::$constCacheArray[$calledClass] = $reflect->getConstants();
            } catch (Exception $exception) {
                die("Error at file". $exception->getFile() . ", line " . $exception->getLine() . ": " . $exception->getMessage());
            }
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false) : bool {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('stroller', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true) : bool {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}