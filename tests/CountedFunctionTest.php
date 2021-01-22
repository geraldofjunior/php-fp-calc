<?php
require "entities/counted_function/CountedFunction.php";
use Point_Calc_Php\Entities\Counted_Function\CountedFunction as CountedFunction;
//use Point_Calc_Php\Entities\Counted_Function\ICountedFunction as ICountedFunction;
use PHPUnit\Framework\TestCase;

class CountedFunctionTest extends TestCase {
    public function testInterface() {
        $function = new CountedFunction("Test Function");
        $this->assertEquals(1,1);
        $this->assertTrue($function instanceof CountedFunction);
    }
}
/*use PHPUnit\Framework\TestCase;
class CountedFunctionTest extends TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
}*/
?>