<?php
namespace Point_Calc_Php\Entities\Counted_Function\Data_Functions;

use Point_calc_Php\Enums\Complexity as Complexity;

use Point_Calc_Php\Entities\Counted_Function\CountedFunction;

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
        } else {
            return Complexity::LOW;
        }
    }

    protected function calculateContribution(): int {
        return match ($this->complexity) {
            Complexity::LOW => 5,
            Complexity::MEDIUM => 7,
            Complexity::HIGH => 10,
            default => 0,
        };
    }
}