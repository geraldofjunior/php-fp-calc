<?php
namespace Point_Calc_Php\Entities\Counted_Function;

require "entities\counted_function\ICountedFunction.interface.php";

class CountedFunction implements ICountedFunction {
    protected string $name = "";
    protected int $functionPoints = 0;
    protected int $complexity = 0;
    protected int $dataTypes;
    protected int $elementaryTypes; // Can be register type (EIF/ILF) or elementary proccess (EI/EQ/EO)

    public function getName(): string {
        return $this->name;
    }

    public function getFunctionPoints(): int {
        return $this->functionPoints;
    }

    public function getComplexity(): int {        
        return $this->complexity;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setContributionData(int $dataTypes, int $registerTypes) {
        $this->dataTypes = $dataTypes;
        $this->elementaryTypes = $registerTypes;
        $this->complexity = $this->calculateComplexity();
        $this->functionPoints = $this->calculateContribution();
    }
    
    protected function calculateComplexity(): int {
        return 1;
    }

    protected function calculateContribution(): int {
        return 1;
    }

    public function __construct(?string $name) {
        $this->name = $name;
    }

}
?>