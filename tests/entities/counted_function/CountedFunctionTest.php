<?php
use Point_Calc_Php\Entities\Counted_Function\CountedFunction as CountedFunction;
use Point_Calc_Php\Entities\Counted_Function\CountedExternalInterfaceFileFunction as CountedExternalInterfaceFileFunction;
use PHPUnit\Framework\TestCase;

require '"D:\Users\Mirai Densetsu\Desktop\Bleberson\Projetos\FPC\php-fp-calc\entities\counted_function\CountedFunction.php"';
//require "entities/counted_function/data_functions/CountedExternalInterfaceFileFunction.php";

class CountedFunctionTest extends TestCase {
    public function testInstantiateAnCountedFunctionObject() {
        
        $function = new CountedFunction("Test Function");
        $this->assertTrue($function instanceof CountedFunction);
    }

    /*public function testInstantiateAnCountedExternalInterfaceFileFunctionObject() {
        
        $function = new CountedExternalInterfaceFileFunction("Test Function");
        $this->assertTrue($function instanceof CountedExternalInterfaceFileFunction);
    }
/*
    public function iCanInstantiateAnCountedFunctionObject() {
        $function = new CountedFunction("Test Function");
        $this->assertTrue($function instanceof CountedFunction);
    }

    public function iCanInstantiateAnCountedFunctionObject() {
        $function = new CountedFunction("Test Function");
        $this->assertTrue($function instanceof CountedFunction);
    }

    public function iCanInstantiateAnCountedFunctionObject() {
        $function = new CountedFunction("Test Function");
        $this->assertTrue($function instanceof CountedFunction);
    }

    public function iCanInstantiateAnCountedFunctionObject() {
        $function = new CountedFunction("Test Function");
        $this->assertTrue($function instanceof CountedFunction);
    }

    public function iCanInstantiateAnCountedFunctionObject() {
        $function = new CountedFunction("Test Function");
        $this->assertTrue($function instanceof CountedFunction);
    }*/
}

?>