<?php
namespace Point_Calc_Php\Entities\Counted_Function\Transactional_Functions;

use Point_calc_Php\Enums\Complexity as Complexity; 
use Point_Calc_Php\Entities\Counted_Function\CountedFunction;

class CountedExternalInquiryFunction extends CountedFunction {
    protected function calculateComplexity(): int {
        if ($this->elementaryTypes < 2) {
            if ($this->dataTypes < 20) {
                return Complexity::LOW;
            } else {
                return Complexity::MEDIUM;
            }
        } else if ($this->elementaryTypes < 4) {
            if ($this->dataTypes < 6) {
                return Complexity::LOW;
            } else if ($this->dataTypes < 20) {
                return Complexity::MEDIUM;
            } else {
                return Complexity::HIGH;
            }
        } else if ($this->elementaryTypes >= 4) {
            if ($this->dataTypes < 6) {
                return Complexity::MEDIUM;
            } else {
                return Complexity::HIGH;
            }
        } else {
            return Complexity::LOW;
        }
    }

    protected function calculateContribution(): int {
        return match ($this->complexity) {
            Complexity::LOW => 3,
            Complexity::MEDIUM => 4,
            Complexity::HIGH => 6,
            default => 0,
        };
    }
}