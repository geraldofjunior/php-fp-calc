<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

interface IAdjustmentFactor {
    public function addInfluenceFactor($type, ?int $value): IAdjustmentFactor;
    public function getInfluenceFactors(): array;
    public function setInfluenceFactors(array $factors) : IAdjustmentFactor;
    public function calculateInfluenceScore(): int;
    public function getInfluenceScore() : int;
    // Database functions
    public function removeInfluenceFactor($type): IAdjustmentFactor;
    public function loadInfluenceFactors(int $id) : IAdjustmentFactor;
    public function saveAllInfluenceFactors() : IAdjustmentFactor;
}