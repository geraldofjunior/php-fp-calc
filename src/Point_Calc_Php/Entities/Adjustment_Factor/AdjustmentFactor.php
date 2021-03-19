<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

use Point_Calc_Php\Core\Services\Database\Connection;
use Point_Calc_Php\Enums\InfluenceType;
use PDO;

class AdjustmentFactor implements IAdjustmentFactor {
    private int $projectId;
    private $influenceFactors = [];
    private int $influenceScore = 0;

    public function __construct() {
    }

    public function addInfluenceFactor($type, ?int $value): void {
        if ($type instanceof InfluenceFactor) {
            $this->addInfluenceFactorByObject($type);
        } else {
            $this->addInfluenceFactorByValue($type, $value);
        }
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

    public function removeInfluenceFactor($type): void {
        if ($type instanceof InfluenceFactor) {
            $_type = $type->getInfluenceType();
        } else if (InfluenceType::isValidValue($type)) {
            $_type = $type;
        } else return;        
        
        if (isset($this->influenceFactors[$_type])) {
            $this->influenceScore -= $this->influenceFactors[$_type];
            $this->influenceFactors[$_type]->remove();
            unset($this->influenceFactors[$_type]);
        }
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

    public function setInfluenceFactors(array $factors) : void {
        foreach ($this->influenceFactors as $type => $factor) {
            if ($factor instanceof InfluenceFactor) {
                $this->addInfluenceFactorByObject($factor);
            } else {
                $this->addInfluenceFactorByValue($type, $factor);
            }
        }
    }

    public function loadInfluenceFactors(int $projectId) : void {
        $this->projectId = $projectId;
        $conn = Connection::getConnection();
        $statement = $conn->prepare("SELECT type, value FROM adjustment_factors WHERE project_id = :id");
        $statement->bindParam(":id", $projectId);
        $factors = $statement->fetchAll(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT, 0);

        foreach($factors as $type => $value) {
            $this->addInfluenceFactorByValue($type, $value);
        }
    }

    public function saveAllInfluenceFactors() : void {
        foreach ($this->influenceFactors as $type => $factor) {
            $factor->save();
        }
    }

    public function getInfluenceScore()  : int   { return $this->influenceScore; }
    public function getInfluenceFactors(): array { return $this->influenceFactors; }
    public function getProjectId()       : int   { return $this->projectId; }
}

?>