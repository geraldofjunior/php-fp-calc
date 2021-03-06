<?php
namespace Point_Calc_Php\Entities\Counted_Function;

interface ICountedFunction {
    public function getName():string;
    public function getFunctionPoints():int;
    public function getComplexity():int;
    public function getFunctionId(): int;
    
    public function setName(string $name) : ICountedFunction;
    public function setContributionData(int $dataTypes, int $registerTypes) : ICountedFunction;
}
?>