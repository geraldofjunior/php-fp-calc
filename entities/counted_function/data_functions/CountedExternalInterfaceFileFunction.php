<?php
namespace Point_Calc_Php\Entities\Counted_Function;
use Point_calc_Php\Enums\Complexity as Complexity;

require_once "entities\counted_function\CountedFunction.php";
require_once "enums\Complexity.enum.php";

class CountedExternalInterfaceFileFunction extends CountedFunction {

    protected function calculateComplexity(): int {
        if ($this->elementaryTypes == 1) {
            if ($this->dataTypes > 50) {
                return Complexity::MEDIUM;
            } else {
                return Complexity::LOW;
            }
        } else if ($this->elementaryTypes >= 2 && $this->elementaryTypes < 6) {
            if ($this->dataTypes >= 51) {
                return Complexity::HIGH;
            } else if ($this->dataTypes < 51 && $this->dataTypes >= 20) {
                return Complexity::MEDIUM;
            } else {
                return Complexity::LOW;
            }
        } else if ($this->elementaryTypes >= 6) {
            if ($this->dataTypes >= 20) {
                return Complexity::HIGH;
            } else {
                return Complexity::MEDIUM;
            }
        }
    }

    protected function calculateContribution(): int {
        switch ($this->complexity) {
            case Complexity::LOW: 
                return 5; 
                break;
            case Complexity::MEDIUM: 
                return 7; 
                break;
            case Complexity::HIGH: 
                return 10; 
                break;
            default: 
                return 0;
                break;
        }
    }
}
?>