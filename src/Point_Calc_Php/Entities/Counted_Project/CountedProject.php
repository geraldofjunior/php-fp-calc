<?php
namespace Point_Calc_Php\Entities\Counted_Project;

use Point_Calc_Php\Entities\Adjustment_Factor\AdjustmentFactor;
use Point_Calc_Php\Entities\Adjustment_Factor\IAdjustmentFactor;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

class CountedProject implements ICountedProject {
    private string $name;
    private $function = [];
    private IAdjustmentFactor $adjustmentFactor;
    private int $estimatedTime = 0;
    private float $estimatedPrice = 0;
    private int $estimatedCount = 0;
    private int $projectType = 0;
    private float $pricePerFP;
    private float $timePerFP;

    public function addFunction(ICountedFunction $function) : void {
        $addedFunctionId = $function->getFunctionId();
        $this->function[$addedFunctionId] = $function;
        $this->calculateFunctionPoints();
        $this->estimatePrice(null);
        $this->estimateTime(null);
    }

    public function removeFunction(ICountedFunction $function) : void {
        $deletedFunctionId = $function->getFunctionId();
        unset($this->function[$deletedFunctionId]);
        $this->calculateFunctionPoints();
        $this->estimatePrice(null);
        $this->estimateTime(null);
    }
    
    public function getFunction(string $name):ICountedFunction {
        $functionName = "";
        if (is_nan($name)) {
            foreach ($this->function as $currentFunction) {
                $functionName = $currentFunction->getName();
                if (strcmp($name, $functionName)) {
                    return $currentFunction;
                }
            }
            return null; // Not found? Null is returned
        } else {
            return $this->function[$name] ?? null;
        }
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

    private function estimatePrice(?float $pricePerFunctionPoint): float {
        $this->pricePerFP = $pricePerFunctionPoint ?? $this->pricePerFP;
        $this->estimatedPrice = $this->estimatedCount * $this->pricePerFP;
        return $this->estimatedPrice;
    }

    private function estimateTime(?float $timePerFunctionPoint): int {
        $this->timePerFP = $timePerFunctionPoint ?? $this->timePerFP;
        $this->estimatedTime = $this->timePerFP * $this->estimatedCount;
        return $this->estimatedCount;
    }

    private function calculateFunctionPoints(): int {
        $count = 0;
        if (is_array($this->function) && count($this->function) > 0) {
            foreach ($this->function as $currentFunction) {
                $count += $currentFunction->getFunctionPoints();
            }
            $this->estimatedCount = $count;
        } else {
            $this->estimatedCount = 0;
        }
        $influence = $this->adjustmentFactor->getInfluenceScore();
        return $this->estimatedCount;
    }

    public function getProjectTotalFunctionPoints(): int {
        return $this->estimatedCount;        
    }

    public function setAdjustmentFactors(array $influences): void {
        if (!isset($this->adjustmentFactor)) {
            $this->adjustmentFactor = new AdjustmentFactor();
        }
        $this->adjustmentFactor->setInfluenceFactors($influences);
    }
}
?>