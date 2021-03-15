<?php
namespace Point_Calc_Php\Core\Controller;

use Point_Calc_Php\Core\Services\Database\Connection;
use Point_Calc_Php\Entities\Counted_Function\CountedFunction;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

class FunctionController extends Controller {
    public function request(string $params) {
    }
    public function insert(string $params) {
    }
    public function update(string $searchParam, string $newData) {
    }
    public function delete(string $searchParam) {
    }

    public function __construct() {
    }

    public function lookForFunction($functionIdentifier) : ICountedFunction {
        // Aqui vai procurar a função no banco (ou sabe-se lá aonde esteja armazenada)
        // Retorno: O objeto de função
        return new CountedFunction("");
    }
}