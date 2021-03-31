<?php
namespace Point_Calc_Php\Core\Services\Database;

use PDO;

abstract class Database implements IDatabase {
    protected PDO $connection;
    
    public abstract function connect():IDatabase;

    public function create(string $table, array $valueList) {
        $fieldList = array_keys($valueList);
        $sql = "INSERT INTO " . $table 
                . " (" . implode(", ", $fieldList) . ") VALUES" 
                . " (" . $this->generateValueList($fieldList) . ")";
        $this->execute($sql, $valueList);
    }

    public function load(string $table, ?array $columns, array $conditions) {
        $sql = "SELECT ";
        $sql .= isset($columns) ? implode(", ", $columns) : "*";
        $sql .= " FROM " . $table . " WHERE " . $this->generateWhere($conditions);
    }

    public function save(string $table, array $newData, array $conditions) {
    }

    public function delete(string $table, array $conditions) {
    }

    protected function generateValueList(array $fieldList) {
        $list = "";
        foreach ($fieldList as $currentField) {
            $list .= ":" . $currentField . ", ";
        }
        return substr($list, 0, strlen($list) - 2);
    }

    protected function generateSet(array $fieldList) {
        $list = "";
        foreach ($fieldList as $currentField) {
            $list .= $currentField . " = :" . $currentField . ", ";
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
        $statement = $this->connection->prepare($sql);

        foreach ($valueList as $field => $value) {
            $statement->bindValue(":".$field, $value);
        }        
        $statement->execute();
    }

    public function getData(string $command, array $conditions): array {
        $statement = $this->connection->prepare($command);

        foreach ($conditions as $condition => $value) {
            $statement->bindValue(":".$condition, $value);
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function executeCommand(string $command): bool {      
        $_command = self::$connection->prepare($command);
        
        return $_command->execute();
    }
}