<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

interface IAdjustmentFactor {
    public function addInfluenceFactor($type, $value): void;
    public function removeInfluenceFactor($type): void;
    public function getInfluenceFactors(): array;
    public function setInfluenceFactors(array $factors) : void;
    public function recalculateInfluenceScore(): int;
    public function getInfluenceScore() : int;
}

?>