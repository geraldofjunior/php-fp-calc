<?php
namespace Point_Calc_Php\Core\Services\Database;

interface IDatabase {
    public function connect() : IDatabase;
    public function load(string $table, ?array $columns, array $conditions);
    public function save(string $table, array $newData, array $conditions);
    public function create(string $table, array $valueList);
    public function delete(string $table, array $conditions);
}