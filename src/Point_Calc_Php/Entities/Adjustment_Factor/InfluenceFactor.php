<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

use Point_Calc_Php\Core\Services\Database\Connection;
use Point_Calc_Php\Enums\InfluenceType;

use InvalidArgumentException;

class InfluenceFactor {
    private int $factorId;
    private int $projectId;
    private int $type;
    private int $value;

    public function __construct() {}

    public function setInfluenceValue(int $value) : InfluenceFactor {
        $this->value = match (true) {
            $value > 5 => 5,
            $this->value < 0 => 0,
            default => $value,
        };

        return $this;
    }

    public function setInfluenceType($type) : InfluenceFactor {
        if (InfluenceType::isValidValue($type)) {
            $this->type = $type;
        } else {
            throw new InvalidArgumentException("Invalid type. Try to stick with types listed on InfluenceType enum.");
        }
        return $this;
    }

    public function setProjectId(int $id) : InfluenceFactor {
        $this->projectId = $id;
        return $this;
    }

    public function setFactorId(int $id) : InfluenceFactor {
        $this->factorId = $id;
        return $this;
    }

    public function save() : InfluenceFactor {
        $condition = ["factor_id" => $this->factorId];
        $values = ["type" => $this->type,
                   "value" => $this->value];
        $conn = Connection::getConnection();
        if (!isset($this->factorId)) {
            $this->factorId = $conn->create("adjustment_factors", $values);
        } else {
            $conn->save("adjustment_factors", $values, $condition);
        }
        return $this;
    }

    public function remove() : void {
        $condition = ["factor_id" => $this->factorId];
        $conn = Connection::getConnection();
        $conn->delete("adjustment_factors", $condition);
    }

    public function getInfluenceValue() : int { return $this->value;     }
    public function getInfluenceType()  : int { return $this->type;      }
    public function getFactorId()       : int { return $this->factorId;  }
    public function getProjectId()      : int { return $this->projectId; }
}