<?php
namespace Point_Calc_Php\services\database;

interface IQueryBuilder {
    public function insert($values);
    public function update($table, $set);
    public function delete($table);
    public function get($values = []);
}
?>