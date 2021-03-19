<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

interface IAdjustmentFactor {
    public function addInfluenceFactor($type, ?int $value): void;
    public function getInfluenceFactors(): array;
    public function setInfluenceFactors(array $factors) : void;
    public function calculateInfluenceScore(): int;
    public function getInfluenceScore() : int;
    // Database functions
    public function removeInfluenceFactor($type): void;
    public function loadInfluenceFactors(int $id) : void;
    public function saveAllInfluenceFactors() : void;
}

?>