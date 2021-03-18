<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

use Point_Calc_Php\Core\Services\Database\Connection;
use PDO;

class AdjustmentFactor implements IAdjustmentFactor {
    private int $id;
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
            $factor = new InfluenceFactor($type, $value);
            $this->influenceFactors[$type] = $factor;
        } else if (isset($value)) {
            $this->influenceFactors[$type]->setInfluenceValue($value);
        }
    }

    private function addInfluenceFactorByObject(InfluenceFactor $factor): void {
        $type = $factor->getInfluenceType();
        $this->influenceFactors[$type] = $factor;
    }

    public function removeInfluenceFactor($type): void {
        if ($type instanceof InfluenceFactor) {
            $_type = $type->getInfluenceType();
        } else {
            $_type = $type;
        }
        if ($_type > 0 && $_type <= 14) {
            if (isset($this->influenceFactors[$_type])) {
                $this->influenceScore -= $this->influenceFactors[$_type];
                unset($this->influenceFactors[$_type]);
            }
        }
    }

    public function getInfluenceFactors(): array {
        return $this->influenceFactors;
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

    public function getInfluenceScore() : int {
        return $this->influenceScore;
    }

    public function load(int $id) : void {
        $conn = Connection::getConnection();
        $statement = $conn->prepare("SELECT type, value FROM adjustment_factors WHERE project_id = :id");
        $statement->bindParam(":id", $id);
        $factors = $statement->fetchAll(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT, 0);
    }

    public function save() : void {

    }
}

?>