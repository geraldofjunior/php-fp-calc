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