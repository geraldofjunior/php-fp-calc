<?php
namespace Point_Calc_Php\Core\Controller;

interface IController {
    public function request(string $searchParam);
    public function insert(string $data);
    public function update(string $searchParam, array $data);
    public function delete(string $searchParam);
}