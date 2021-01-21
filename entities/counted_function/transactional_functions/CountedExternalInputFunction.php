<?php
namespace Point_Calc_Php\Entities\Counted_Function;
use Point_calc_Php\Enums\Complexity as Complexity; 

class CountedExternalInputFunction extends CountedFunction {
    protected function calculateComplexity(): int {
        if ($this->elementaryTypes < 2) {
            if ($this->dataTypes < 15) {
                return Complexity::LOW;
            } else {
                return Complexity::MEDIUM;
            }
        } else if ($this->elementaryTypes == 2) {
            if ($this->dataTypes < 5) {
                return Complexity::LOW;
            } else if ($this->dataTypes < 15) {
                return Complexity::MEDIUM;
            } else {
                return Complexity::HIGH;
            }
        } else if ($this->elementaryTypes > 2) {
            if ($this->dataTypes < 5) {
                return Complexity::MEDIUM;
            } else {
                return Complexity::HIGH;
            }
        }
    }

    protected function calculateContribution(): int {
        switch ($this->complexity) {
            case Complexity::LOW: 
                return 3; 
                break;
            case Complexity::MEDIUM: 
                return 4; 
                break;
            case Complexity::HIGH: 
                return 6; 
                break;
            default: 
                return 0;
                break;
        }
    }
}
?>