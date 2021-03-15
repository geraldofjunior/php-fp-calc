<?php
namespace Point_Calc_Php\Core\Controller;

interface IController {
    public function request(string $params);
    public function insert(string $params);
    public function update(string $searchParam, string $newData);
    public function delete(string $searchParam);
}