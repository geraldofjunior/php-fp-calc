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
        $sql  = "INSERT INTO "; 
        $sql .= isset($this->params['table']) ? $this->params['table'] : '<table>';
        $sql .= '(' . isset($this->params['fields']) ? implode(', ', $this->params['fields']) : '<fields>';
        $sql .= ') VALUES ';
        $sql .= implode(', ', $values);

        return $this->executeInsert($sql);
    }
    public function update($table, $set) {

    }
    public function delete($table) {

    }
    public function get($values = []) {
        $table  = isset($this->params['table']) ? $this->clausules['table'] : '<table>';
        $fields = isset($this->params['fields']) ? implode(', ', $this->params['fields']) : '*';
        $join   = isset($this->params['join']) ? $this->params['join'] : '';

        $sql  = 'SELECT ';
        $sql .= $fields;
        $sql .= ' FROM ';
        $sql .= $table;
        if ($join) $sql .= $join;
        $clausules = [
            'where' => [
                'instruction' => 'WHERE',
                'separator' => ' '
            ],
            'group' => [
                'instruction' => 'GROUP BY',
                'separator' => ', '
            ],
            'order' => [
                'instruction' => 'ORDER BY',
                'separator' => ', '
            ],
            'having' => [
                'instruction' => 'HAVING',
                'separator' => ' AND '
            ],
            'limit' => [
                'instruction' => 'LIMIT',
                'separator' => ','
            ]
        ];

        foreach ($clausules as $key => $clausule) {
            if (isset($this->params[$key])) {
                $value = $this->params[$key];
                if ()
            }
        }
    }
}
?>