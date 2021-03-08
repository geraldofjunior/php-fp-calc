<?php
namespace Point_Calc_Php;

use InvalidArgumentException;
use Point_Calc_Php\Entities\Adjustment_Factor\InfluenceFactor as InfluenceFactor;
use Point_Calc_Php\Enums\InfluenceType as InfluenceType;


use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\{ 
    assertEquals,
    assertIsInt, 
    assertTrue     
};

class InfluenceFactorTest extends TestCase {
    public function test_if_InfluenceFactor_instantiates() {
        $influence = rand();
        $type = InfluenceType::PERFORMANCE;
        $testObject = new InfluenceFactor($type, $influence);
        assertTrue($testObject instanceof InfluenceFactor, "Test if the object even instantiates. It should do it");
        return $testObject;
    }
    
    /**
     * @depends test_if_InfluenceFactor_instantiates
     */
    public function test_influence_value_when_receiving_nan($testObject) {
        $notANumber = "Lorem Ipsum";
        $this->expectErrorMessageMatches("/must be of type int/");
        $testObject->setInfluenceValue($notANumber);
    }

    /**
     * @depends test_if_InfluenceFactor_instantiates
     */
    public function test_influence_value_when_receiving_greater($testObject) {
        $greater = rand(6, 10000);
        $testObject->setInfluenceValue($greater);
        assertEquals(5, $testObject->getInfluenceValue(), "If the value is greater than 5, it shoud round down to 5");
    }

    /**
     * @depends test_if_InfluenceFactor_instantiates
     */
    public function test_influence_value_when_receiving_lesser($testObject) {
        $lesser = rand(1, 10000) * -1;
        $testObject->setInfluenceValue($lesser);
        assertEquals(0, $testObject->getInfluenceValue(), "It should round negative numbers up to zero");
    }
    
    /**
     * @depends test_if_InfluenceFactor_instantiates
     */
    public function test_influence_value_when_receiving_an_ok_value($testObject) {
        $okayishValue = rand(0,5);
        $testObject->setInfluenceValue($okayishValue);
        assertTrue($testObject->getInfluenceValue() >= 0 && $testObject->getInfluenceValue() <= 5, "Okayish value should be between 0 and 5.");
    }

    /**
     * @depends test_if_InfluenceFactor_instantiates
     */
    public function test_influence_type_when_receiving_an_ok_value($testObject) {
        $okayishValue = rand(1,15);
        $testObject->setInfluenceType($okayishValue);
        assertIsInt($testObject->getInfluenceType(), "Okayish values should be an Int");
        //assertTrue(InfluenceType::isValidValue($testObject->getInfluenceType()), "Okayish values should be inside of what the Enum allows");
    }

    /**        
     * @depends test_if_InfluenceFactor_instantiates
    */
    public function test_influence_type_when_receiving_an_value_too_low($testObject) {
        $lesser = rand(0, 10000) * -1;
        $this->expectException(InvalidArgumentException::class);
        $testObject->setInfluenceType($lesser);
    }

    /** 
     * @depends test_if_InfluenceFactor_instantiates
    */
    public function test_influence_type_when_receiving_an_value_too_high($testObject) {
        $greater = rand(16, 10000) * -1;
        $this->expectException(InvalidArgumentException::class);
        $testObject->setInfluenceType($greater);
    }

    /** 
     * @depends test_if_InfluenceFactor_instantiates
    */
    public function test_influence_type_when_receiving_an_value_that_is_nan($testObject) {
        $notANumber = "jklahdsfgkaj";
        $this->expectException(InvalidArgumentException::class);
        $testObject->setInfluenceType($notANumber);
    }
}