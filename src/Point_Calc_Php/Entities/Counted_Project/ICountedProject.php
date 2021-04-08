<?php
namespace Point_Calc_Php\Entities\Counted_Project;

use Point_Calc_Php\Entities\Adjustment_Factor\IAdjustmentFactor;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;

interface ICountedProject {
    public function addFunction(ICountedFunction $function):ICountedProject;
    public function removeFunction(ICountedFunction $function):ICountedProject;
    public function getFunction(string $name):ICountedFunction | null;
    public function getAllFunctions() : array;
    public function getProjectType():int;
    public function setProjectType(int $projectType);
    public function getEstimatedPrice(): float;
    public function getEstimatedTime(): int;
    public function getEstimatedFunctionPoints(): int;
    public function getAdjustmentFactors():IAdjustmentFactor;
    public function addAdjustmentFactor(int $type, int $value):ICountedProject;
    public function removeAdjustmentFactor(int $type):ICountedProject;
    public function getName():string;
    public function setName(string $name):ICountedProject;
    public function setAdjustmentFactors(array $influences):ICountedProject;
}