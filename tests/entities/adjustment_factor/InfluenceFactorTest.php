<?php
use Point_Calc_Php\Entities\Adjustment_Factor\InfluenceFactor;
use Point_Calc_Php\Enums\InfluenceType;
use InvalidArgumentException;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\{ 
    assertContains, 
    assertEquals, 
    assertGreaterThan, 
    assertIsInt, 
    assertNan, 
    assertTrue     
};

class InfluenceFactorTest extends TestCase {
    public function initTestedObject() {
        $influence = rand();
        $type = InfluenceType::PERFORMANCE;
        $testObject = new InfluenceFactor($type, $influence);
        return $testObject;
    }

    public function test_if_InfluenceFactor_instantiates() {
        $influence = rand();
        $type = InfluenceType::PERFORMANCE;
        $testObject = new InfluenceFactor($type, $influence);
        assert($testObject instanceof InfluenceType, "Test if the object even instantiates. It should do it");

        return $testObject;
    }
    
    /**
     * @depends test_if_InfluenceFactor_instantiates
     */
    public function test_influence_value_when_receiving_nan($testObject) {
        $notANumber = "Lorem Ipsum";
        $testObject->setInfluenceValue($notANumber);
        $this->assertIsInt($testObject->getInfluenceValue(), "Test if the value is even an int. It should be.");
    }

    public function test_influence_value_when_receiving_greater() {
        $testObject = $this->initTestedObject();
        $greater = rand(6, 10000);
        $testObject->setInfluenceValue($greater);
        $this->assertEquals(5, $testObject->getInfluenceValue(), "If the value is greater than 5, it shoud round down to 5");
    }

    public function test_influence_value_when_receiving_lesser() {
        $testObject = $this->initTestedObject();
        $lesser = rand(1, 10000) * -1;
        $testObject->setInfluenceValue($lesser);
        $this->assertEquals(0, $testObject->getInfluenceValue(), "It should round negative numbers up to zero");
    }
    
    public function test_influence_value_when_receiving_an_ok_value() {
        $testObject = $this->initTestedObject();
        $okayishValue = rand(0,5);
        $testObject->setInfluenceValue($okayishValue);
        assert($testObject->getInfluenceValue() >= 0 && $testObject->getInfluenceValue() <= 5, "Okayish value should be between 0 and 5.");
    }

    public function test_influence_type_when_receiving_an_ok_value() {
        $testObject = $this->initTestedObject();
        $okayishValue = rand(1,15);
        try {
            $testObject->setInfluenceType($okayishValue);
            $this->assertIsInt($testObject->getInfluenceType(), "Okayinsh values should be an Int");
            assert(InfluenceType::isValidValue($testObject->getInfluenceType()), "Okayinsh values should be inside of what the Enum allows");
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(false, "It shoudnt throw an error with those values");
        }
    }

    /** 
     * @expectedException        InvalidArgumentException
    */
    public function test_influence_type_when_receiving_an_value_too_low() {
        $testObject = $this->initTestedObject();
        $lesser = rand(0, 10000) * -1;
        $testObject->setInfluenceType($lesser);
    }

    /** 
     * @expectedException        InvalidArgumentException
    */
    public function test_influence_type_when_receiving_an_value_too_high() {
        $testObject = $this->initTestedObject();
        $greater = rand(16, 10000) * -1;
        $testObject->setInfluenceType($greater);
    }

    /** 
     * @expectedException        InvalidArgumentException
    */
    public function test_influence_type_when_receiving_an_value_that_is_nan() {
        $testObject = $this->initTestedObject();
        $notANumber = "jklahdsfgkaj";
        $testObject->setInfluenceType($notANumber);
    }
}