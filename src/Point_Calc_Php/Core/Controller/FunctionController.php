<?php
namespace Point_Calc_Php\Core\Controller;

use Point_Calc_Php\Entities\Counted_Function\CountedFunction;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

class FunctionController extends Controller {
    public function requestFunctionPage(int $functionId): void {
        // Aqui vai pegar o ID da página e retornar a página correspondente à função
    }

    public function lookForFunction($functionIdentifier) : ICountedFunction {
        // Aqui vai procurar a função no banco (ou sabe-se lá aonde esteja armazenada)
        // Retorno: O objeto de função
        return new CountedFunction("");
    }
}