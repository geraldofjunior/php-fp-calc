<?php
namespace Point_Calc_Php\Entities\Counted_Project;

use Point_Calc_Php\Entities\Adjustment_Factor\IAdjustmentFactor;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

interface ICountedProject {
    public function addFunction(ICountedFunction $function);
    public function removeFunction(ICountedFunction $function);
    public function getFunction(string $name):ICountedFunction;
    public function getAllFunctions() : array;
    public function getProjectType():int;
    public function setprojectType(int $projectType);
    public function getEstimatedPrice(): float;
    public function getEstimatedTime(): int;
    public function getEstimatedFunctionPoints(): int;
    public function getAdjustmentFactors():IAdjustmentFactor;
    public function addAdjustmentFactor(int $type, int $value):void;
    public function removeAdjustmentFactor(int $type);
    public function getName():string;
    public function setName(string $name);
    public function setAdjustmentFactors(array $influences);
}
?>