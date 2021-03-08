<?php
use Point_Calc_Php\Entities\Counted_Function\CountedFunction;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction as CountedFunction_interface;
use Point_Calc_Php\Entities\Counted_Function\CountedExternalInterfaceFileFunction;
use Point_Calc_Php\Entities\Counted_Function\CountedInternalLogicalFileFunction;

use PHPUnit\Framework\TestCase;

require "entities\counted_function\CountedFunction.php";
//require "entities\counted_function\ICountedFunction.interface.php";
require "entities\counted_function\data_functions\CountedExternalInterfaceFileFunction.php";
class CountedFunctionTest extends TestCase {
    private CountedFunction_interface $countedFunction;

    public function test_Instantiate_An_CountedFunctionObject() {  
        $function = new CountedFunction("Test Function");
        $this->assertTrue($function instanceof CountedFunction);
    }

    public function test_instantiate_an_CountedExternalInterfaceFileFunction_object() {        
        $function = new CountedExternalInterfaceFileFunction("Test Function");
        $this->countedFunction = $function;
        $this->assertTrue($function instanceof CountedExternalInterfaceFileFunction);
    }

    public function test_setContributionData() {
        $function = new CountedExternalInterfaceFileFunction("Test Function");
        $function->setContributionData(1, 1);
        $this->assertIsInt($function->getComplexity(), "Is its return is INT?");
        $this->assertEquals(1, $function->getComplexity());
    }
/*
    public function iCanInstantiateAnCountedInternalLogicalFileFunctionObject() {
        $function = new CountedInternalLogicalFileFunction("Test Function");
        $this->assertTrue($function instanceof );
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