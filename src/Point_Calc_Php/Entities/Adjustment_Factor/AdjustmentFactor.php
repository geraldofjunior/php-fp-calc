<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

use Point_Calc_Php\Core\Services\Database\Connection;
use Point_Calc_Php\Enums\InfluenceType;

class AdjustmentFactor implements IAdjustmentFactor {
    private int $projectId;
    private array $influenceFactors = [];
    private int $influenceScore = 0;

    public function __construct() {
    }

    public function addInfluenceFactor($type, ?int $value): IAdjustmentFactor {
        if ($type instanceof InfluenceFactor) {
            $this->addInfluenceFactorByObject($type);
        } else {
            $this->addInfluenceFactorByValue($type, $value);
        }
        return $this;
    }

    private function addInfluenceFactorByValue(int $type, ?int $value): void {
        if (!isset($this->influenceFactors[$type])) {
            $factor = (new InfluenceFactor())
                ->setProjectId($this->projectId)
                ->setInfluenceType($type)
                ->setInfluenceValue($value)
                ->save();
            $this->influenceFactors[$type] = $factor;
        } else if (isset($value)) {
            $this->influenceFactors[$type]
                ->setInfluenceValue($value)
                ->save();
        }
    }

    private function addInfluenceFactorByObject(InfluenceFactor $factor): void {
        $type = $factor->getInfluenceType();
        $this->influenceFactors[$type] = $factor;
    }

    public function removeInfluenceFactor($type): IAdjustmentFactor {
        if ($type instanceof InfluenceFactor) {
            $_type = $type->getInfluenceType();
        } else if (InfluenceType::isValidValue($type)) {
            $_type = $type;
        } else {
            return $this;
        }
        
        if (isset($this->influenceFactors[$_type])) {
            $this->influenceScore -= $this->influenceFactors[$_type];
            $this->influenceFactors[$_type]->remove();
            unset($this->influenceFactors[$_type]);
        }

        return $this;
    }

    public function calculateInfluenceScore(): int {
        $influence = 0;
        if (sizeof($this->influenceFactors) > 0) {
            foreach ($this->influenceFactors as $factor) {
                $influence += $factor;
            }
            $this->influenceScore = $influence;
        } 
        return $influence;
    }

    public function setInfluenceFactors(array $factors) : IAdjustmentFactor {
        foreach ($this->influenceFactors as $type => $factor) {
            if ($factor instanceof InfluenceFactor) {
                $this->addInfluenceFactorByObject($factor);
            } else {
                $this->addInfluenceFactorByValue($type, $factor);
            }
        }
        return $this;
    }

    public function loadInfluenceFactors(int $id) : IAdjustmentFactor {
        $this->projectId = $id;
        $conn = Connection::getConnection();

        $condition = [ "project_id" => $this->projectId ];
        $factors = $conn->load("adjustment_factors", [ "type", "value" ], $condition );

        foreach($factors as $type => $value) {
            $this->addInfluenceFactorByValue($type, $value);
        }

        return $this;
    }

    public function saveAllInfluenceFactors() : IAdjustmentFactor {
        foreach ($this->influenceFactors as $factor) {
            $factor->save();
        }
        return $this;
    }

    public function getInfluenceScore()  : int   { return $this->influenceScore; }
    public function getInfluenceFactors(): array { return $this->influenceFactors; }
    public function getProjectId()       : int   { return $this->projectId; }
}