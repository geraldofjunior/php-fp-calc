<?php
namespace Point_Calc_Php\Entities\Adjustment_Factor;

use InvalidArgumentException;
use Point_Calc_Php\Enums\InfluenceType;

//require "src\enums\InfluenceType.enum.php";

class InfluenceFactor {
    private int $type;
    private int $value;

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
    }

    public function setInfluenceType($type) {
        if (InfluenceType::isValidValue($type)) {
            $this->value = $type;
        } else {
            throw new InvalidArgumentException("Invalid type. Try to stick with types listed on InfluenceType enum.");
        }
    }

    public function getInfluenceValue() : int {
        return $this->value;
    }

    public function getInfluenceType() : int {
        return $this->type;
    }

    public function __construct(?int $type, ?int $value) {
        $this->type = $this->setInfluenceType($type) ?? 0;
        $this->value = $this->setInfluenceValue($value) ?? 0;
    }

}