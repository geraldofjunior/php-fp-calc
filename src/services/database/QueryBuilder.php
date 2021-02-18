<?php
namespace Point_Calc_Php\services;

class QueryBuilder implements IQueryBuilder {

    private $params = [];

    public function __call($name, $args) {
        $params = $args[0];

        if (count($args) > 1) {
            $params = $args;
        }
        $this->params[$name] = $params;
    }

    public function insert($values) {
        $table = isset($this->params['table']) ? $this->params['table'] : '<table>';
    }
    public function update($table, $set) {

    }
    public function delete($table) {

    }
    public function get($table, $fields) {

    }
}
?>