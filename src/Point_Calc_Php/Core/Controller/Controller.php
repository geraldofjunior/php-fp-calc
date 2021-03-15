<?php
namespace Point_Calc_Php\Core\Controller;

use Point_Calc_Php\Core\Services\Database\Connection;

abstract class Controller implements IController {
    protected Connection $conn;

    public abstract function request(string $params);
    public abstract function insert(string $params);
    public abstract function update(string $searchParam, string $newData);
    public abstract function delete(string $searchParam);
}