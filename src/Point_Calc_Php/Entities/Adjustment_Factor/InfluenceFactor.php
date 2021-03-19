<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

use Point_Calc_Php\Core\Services\Database\Connection;
use Point_Calc_Php\Enums\InfluenceType;

// Intellephense "forces" me to explicitly declare PHP built-in classes
use InvalidArgumentException, PDO; 
class InfluenceFactor {
    private int $factorId;
    private int $projectId;
    private int $type;
    private int $value;

    public function __construct() {}

    public function setInfluenceValue(int $value) {
        if (is_nan($value)) {
            $this->value = 0;
        } else if ($value > 5) {
            $this->value = 5;
        } else if ($value < 0) {
            $this->value = 0;
        } else {
            $this->value = $value;
        }
        return $this;
    }

    public function setInfluenceType($type) {
        if (InfluenceType::isValidValue($type)) {
            $this->value = $type;
        } else {
            throw new InvalidArgumentException("Invalid type. Try to stick with types listed on InfluenceType enum.");
        }
        return $this;
    }

    public function setProjectId(int $id) {
        $this->projectId = $id;
        return $this;
    }

    public function setFactorId(int $id) {
        $this->factorId = $id;
        return $this;
    }

    public function save() {
        $conn = Connection::getConnection();
        if (isset($this->factorId)) {
            $query = $conn->prepare("UPDATE adjustment_factors SET type = :type, value = :value WHERE factor_id = :id");
            $query->bindValue(":type", $this->type);
            $query->bindValue(":value", $this->value);
            $query->bindParam(":id", $this->id);
            $query->execute();
        } else {
            $this->create($conn);
        }
        return $this;
    }

    private function create(PDO &$conn) {
        $conn = Connection::getConnection();
        
        $query = $conn->prepare("INSERT INTO adjustment_factors (project_id, type, value) VALUES (:project_id, :type, :value)");
        $query->bindValue(":type", $this->type ?? null);
        $query->bindValue(":value", $this->value ?? null);
        $query->bindValue(":project_id", $this->projectId);
        $query->execute();

        $this->factorId = $conn->lastInsertId();
    }

    public function remove() {
        $conn = Connection::getConnection();

        $query = $conn->prepare("DELETE FROM adjustment_factors WHERE factor_id = :id");
        $query->bindValue(":id", $this->factorId);
        $query->execute();
    }

    public function getInfluenceValue() : int { return $this->value;     }
    public function getInfluenceType()  : int { return $this->type;      }
    public function getFactorId()       : int { return $this->factorId;  }
    public function getProjectId()      : int { return $this->projectId; }
}