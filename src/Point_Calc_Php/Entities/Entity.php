<?php
namespace Point_Calc_Php\Entities;

use InvalidArgumentException, PDOStatement;
use Point_Calc_Php\Core\Services\Database\Connection;

abstract class Entity {
    protected string $table;

    // TODO: Complete this class

    public function create(array $valueList) {
    }
    
    public function read(array $valueList, array $searchCondition) {
    }

    public function save() {
    }

    public function delete() {
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