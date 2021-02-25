<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

class AdjustmentFactor implements IAdjustmentFactor {
    private $influenceFactors = [];
    private int $influenceScore = 0;

    public function __construct() {
    }

    public function addInfluenceFactor($type, $value): void {
        $_value = $value; 
        if ($type > 0 && $type <= 14) {
            if ($_value > 0 && $_value <= 5) {
                if ($_value > 5) {
                    $_value = 5;    
                }
                $this->influenceFactors[$type] = $_value;
                $this->influenceScore += $_value;
            }
        }    
    }

    public function removeInfluenceFactor($type): void {
        if ($type > 0 && $type <= 14) {
            if (isset($this->influenceFactors[$type])) {
                $this->influenceScore -= $this->influenceFactors[$type];
                unset($this->influenceFactors[$type]);
            }
        }
    }

    public function getInfluenceFactors(): array {
        return $this->influenceFactors;
    }

    public function recalculateInfluenceScore(): int {
        $influence = 0;
        if (sizeof($this->influenceFactors) > 0) {
            foreach ($this->influenceFactors as $factor) {
                $influence += $factor;
            }
            $this->influenceScore = $influence;
        } 
        return $influence;
    }
}

?>