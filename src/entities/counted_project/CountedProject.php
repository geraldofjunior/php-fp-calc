<?php
namespace Point_Calc_Php\Entities\Counted_Project;

use Point_Calc_Php\Entities\Adjustment_Factor\AdjustmentFactor;
use Point_Calc_Php\Entities\Adjustment_Factor\IAdjustmentFactor;
use Point_Calc_Php\Entities\Counted_Function\CountedFunction;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

class CountedProject implements ICountedProject {
    private string $name;
    private $function = [];
    private IAdjustmentFactor $adjustmentFactor;
    private int $estimatedTime = 0;
    private float $estimatedPrice = 0;
    private int $estimatedCount = 0;
    private int $projectType = 0;

    public function addFunction(ICountedFunction $function) : void {
        $this->function[] = $function;
    }

    public function removeFunction(ICountedFunction $function) : void {}
    
    public function getFunction(string $name):ICountedFunction {
        return new CountedFunction("New function");
    }

    public function getAllFunctions() : array {
        return $this->function;
    }

    public function getProjectType():int {
        return $this->projectType;
    }

    public function setprojectType(int $projectType) : void {
        $this->projectType = $projectType;
    }

    public function getEstimatedPrice() : float {
        return $this->estimatedPrice;
    }

    public function getEstimatedTime() : int {
        return $this->estimatedTime;
    }

    public function getEstimatedFunctionPoints() : int {
        return $this->estimatedCount;
    }

    public function getAdjustmentFactors():IAdjustmentFactor {
        return $this->adjustmentFactor;
    }

    public function addAdjustmentFactor(int $type, int $value) : void {
        $this->adjustmentFactor->addInfluenceFactor($type, $value);
    }

    public function removeAdjustmentFactor(int $type) : void {
        $this->adjustmentFactor->removeInfluenceFactor($type);
    }
    
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

    public function getProjectTotalFunctionPoints(): int {
        return $this->estimatedCount;        
    }
}
?>