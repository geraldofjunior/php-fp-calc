<?php
namespace Point_Calc_Php\Entities\Counted_Project;

use Point_Calc_Php\Entities\Adjustment_Factor\IAdjustmentFactor;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

interface ICountedProject {
    public function addFunction(ICountedFunction $function);
    public function removeFunction(ICountedFunction $function);
    public function getFunction(string $name):ICountedFunction;
    public function getAllFunctions();
    public function getProjectType():int;
    public function setprojectType(int $projectType);
    public function getPrice();
    public function getEstimatedTime();
    public function getProjectTotalFunctionPoints();
    public function getAdjustmentFactors():IAdjustmentFactor;
    public function addAdjustmentFactor(IAdjustmentFactor $factor);
    public function removeAdjustmentFactor(IAdjustmentFactor $factor);
    public function getName():string;
    public function setName(string $name);
}
?>