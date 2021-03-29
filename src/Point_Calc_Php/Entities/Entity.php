<?php
namespace Point_Calc_Php\Entities;

use InvalidArgumentException, PDOStatement;
use Point_Calc_Php\Core\Services\Database\Connection;

abstract class Entity {
    protected string $table;

    // TODO: Complete this class

    public function create(array $valueList) {
        $fieldList = array_keys($valueList);
        $sql = "INSERT INTO " . $this->table 
                . " (" . $this->generateFieldList($fieldList) . ") VALUES" 
                . " (" . $this->generateValueList($fieldList) . ")";
        $this->execute($sql, $valueList);
    }
    
    public function read(array $valueList, array $searchCondition) {
        $fieldList = array_keys($valueList);
        $sql = "SELECT " . 
    }

    public function save() {
    }

    public function delete() {
    }

    protected function generateFieldList(array $fieldList) {
        $list = "";
        foreach ($fieldList as $currentfield) {
            $list .= $currentfield . ", ";
        }
        return substr($list, 0, strlen($list) - 2);
    }

    protected function generateValueList(array $fieldList) {
        $list = "";
        foreach ($fieldList as $currentField) {
            $list .= ":" . $currentField . ", ";
        }
        return substr($list, 0, strlen($list) - 2);
    }

    protected function generateSetList(array $fieldList) {
        $list = "";
        foreach ($fieldList as $currentField) {
            $list .= $currentField . " = " . ":" . $currentField . ", ";
        }
        return substr($list, 0, strlen($list) - 2);
    }

    // TODO: Turn this method yet more generic, adding more conditions than just AND
    protected function generateWhere(array $valueList) {
        $list = "";
        foreach ($valueList as $field => $value) {
            if (is_string($value)) {
                $list .= $field . " LIKE :" . $field . "_cond ";
            } else {
                $list .= $field . " = :" . $field . "_cond ";
            }
            $list .= " AND ";
        }
        return substr($list, 0, strlen($list) - 4);
    }

    protected function execute(string $sql, array $valueList) {
        $conn = Connection::getConnection();
        $statement = $conn->prepare($sql);

        foreach ($valueList as $field => $value) {
            $statement->bindValue(":".$field, $value);
        }        
        $statement->execute();
    }

    // Forces clients to use the setter and getter

    public function __get(string $field) {
        $getter = "get".ucfirst($field);
        if (property_exists($this, $field) && 
            method_exists($this, $getter)  && 
            is_callable(array($this, $getter))) {
            return $this->$getter();
        } else {
            throw new InvalidArgumentException("The field ".$field." cannot be accessed from this scope. Use the getter.");
        }
    }

    public function __set(string $field, mixed $value) {
        $setter = "set".ucfirst($field);
        if (property_exists($this, $field) && 
            method_exists($this, $setter)  && 
            is_callable(array($this, $setter))) {
            return $this->$setter($value);
        } else {
            throw new InvalidArgumentException("The field ".$field." cannot be set from this scope. Use the setter.");
        }
    }
}