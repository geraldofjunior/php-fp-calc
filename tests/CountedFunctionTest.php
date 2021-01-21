<?php
namespace Point_Calc_Php\Entities\Counted_Function;

use PHPUnit\Framework\TestCase;

class CountedFunctionTest extends TestCase {
    public function testInterface() {
        /* This will test if using the interface we can use any function */
        $function = new CountedFunction("Test Function");
        return $this->assertTrue($function instanceof ICountedFunction);
    }
}
?>