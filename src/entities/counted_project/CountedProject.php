<?php
namespace Point_Calc_Php\Entities\Counted_Project;

use Point_Calc_Php\Entities\Adjustment_Factor\AdjustmentFactor;
use Point_Calc_Php\Entities\Adjustment_Factor\IAdjustmentFactor;
use Point_Calc_Php\Entities\Counted_Function\CountedFunction;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

class CountedProject implements ICountedProject {
    private string $name;
    private array $function = array();
    private array $adjustmentFactor = array();
    private int $estimatedTime = 0;
    private float $estimatedPrice = 0;
    private int $estimatedCount = 0;
    private int $projectType = 0;

    public function addFunction(ICountedFunction $function) {
        $this->function[] = $function;

    }

    public function removeFunction(ICountedFunction $function) {}
    
    public function getFunction(string $name):ICountedFunction {
        return new CountedFunction("New function");
    }

    public function getAllFunctions() {
        return $this->function;
    
    }

    public function getProjectType():int {
        return 0;
    }

    public function setprojectType(int $projectType) {
        $this->projectType = $projectType;
    }

    public function getPrice() {
        return $this->estimatedPrice;
    }

    public function getEstimatedTime() {
        return $this->estimatedTime;
    }

    public function getProjectTotalFunctionPoints() {
        return $this->estimatedCount;
    }

    public function getAdjustmentFactors():IAdjustmentFactor {
        return new AdjustmentFactor();
    }

    public function addAdjustmentFactor(IAdjustmentFactor $factor) {
        $this->adjustmentFactor[] = $factor;
    }

    public function removeAdjustmentFactor(IAdjustmentFactor $factor) {}
    
    public function getName():string {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    private function estimatePrice(float $pricePerFunctionPoint) {
        $this->estimatedPrice = 0;
    }

    private function estimateTime(float $timePerFunctionPoint) {
        $this->estimatedTime = 0;
    }

    private function calculateFunctionPoints() {
        $this->estimatedCount = 0;

    }
}
?>