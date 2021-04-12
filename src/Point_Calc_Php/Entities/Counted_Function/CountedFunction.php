<?php
namespace Point_Calc_Php\Entities\Counted_Function;

use Point_Calc_Php\Enums\Complexity;

class CountedFunction implements ICountedFunction {
    protected int $functionId;
    protected string $name = "";
    protected int $functionPoints = 0;
    protected int $complexity = 0;
    protected int $dataTypes = 0;
    protected int $elementaryTypes = 0; // Can be register type (EIF/ILF) or elementary process (EI/EQ/EO)

    /* Yet hard-coded, but way better now  */

    protected array $elementValues = [ "low" => 2, "high" => 5 ];
    protected array $dataValues = [ "low" => 25, "high" => 50 ];
    protected array $complexityTable = [
        [ Complexity::LOW, Complexity::LOW, Complexity::MEDIUM],
        [ Complexity::LOW, Complexity::MEDIUM, Complexity::HIGH ],
        [ Complexity::MEDIUM, Complexity::HIGH, Complexity::HIGH]
    ];
    protected array $contributionTable = [ Complexity::LOW => 7, Complexity::MEDIUM => 10, Complexity::HIGH => 15 ];

    public function getName(): string { return $this->name; }
    public function getFunctionPoints(): int { return $this->functionPoints; }
    public function getComplexity(): int { return $this->complexity; }

    public function setName(string $name) : ICountedFunction {
        $this->name = $name;
        return $this;
    }

    public function setContributionData(int $dataTypes, int $registerTypes) : ICountedFunction {
        $this->dataTypes = $dataTypes;
        $this->elementaryTypes = $registerTypes;
        $this->complexity = $this->calculateComplexity();
        $this->functionPoints = $this->calculateContribution();
        return $this;
    }

    public function setDataTypes(int $dataTypes) : ICountedFunction {
        $this->dataTypes = $dataTypes;
        return $this;
    }

    public function setElementaryTypes(int $elementaryTypes) : ICountedFunction {

    }

    /** Yet hard-coded, but way better now  */

    protected function getCoordinate(int $value, bool $isDataValue) : int {
        $data = $isDataValue ? $this->dataValues : $this->elementValues;
        return match (true) {
            $value <= $data["low"] => 0,
            $value >= $data["high"] => 2,
            $value > $data["low"] && $value < $data["high"] => 1,
            default => -1,
        };
    }

    protected function calculateComplexity() : int {
        $dataAddress = $this->getCoordinate($this->dataTypes, true);
        $elementAddress = $this->getCoordinate($this->elementTypes, false);
        $this->complexity = $this->complexityTable[$elementAddress][$dataAddress];
        return $this->complexity;
    }

    protected function calculateContribution(): int {
        return isset($this->complexity) ?
            $this->contributionTable[$this->complexity] :
            $this->contributionTable[$this->calculateComplexity()];
    }

    public function __construct(?string $name = "") {
        $this->name = $name ?? "";
    }

    public function getFunctionId() : int {
        return $this->functionId;
    }
}