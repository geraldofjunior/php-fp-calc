<?php
namespace Point_Calc_Php\Entities\Counted_Project;

use Point_Calc_Php\Entities\Adjustment_Factor\AdjustmentFactor;
use Point_Calc_Php\Entities\Adjustment_Factor\IAdjustmentFactor;
use Point_Calc_Php\Entities\Counted_Function\ICountedFunction;
use Point_Calc_Php\Core\Services\Database\Connection;
use Point_Calc_Php\Enums\ProjectType;

class CountedProject implements ICountedProject {
    private int $projectId;
    private int $ownerId;
    private string $name;
    private $function = [];
    private IAdjustmentFactor $adjustmentFactor;
    private int $estimatedTime = 0;
    private float $estimatedPrice = 0;
    private int $estimatedCount = 0;
    private int $projectType = 0;
    private float $pricePerFP;
    private float $timePerFP;

    public function __construct() {        
    }

    public function addFunction(ICountedFunction $function) : ICountedProject {
        $addedFunctionId = $function->getFunctionId();
        $this->function[$addedFunctionId] = $function;
        $this->calculateFunctionPoints();
        $this->estimatePrice(null);
        $this->estimateTime(null);
        return $this;
    }

    public function removeFunction(ICountedFunction $function) : ICountedProject {
        $deletedFunctionId = $function->getFunctionId();
        unset($this->function[$deletedFunctionId]);
        $this->calculateFunctionPoints();
        $this->estimatePrice(null);
        $this->estimateTime(null);
        return $this;
    }
    
    public function addAdjustmentFactor(int $type, int $value) : ICountedProject {
        $this->adjustmentFactor->addInfluenceFactor($type, $value);
        return $this;
    }
    
    public function removeAdjustmentFactor(int $type) : ICountedProject {
        $this->adjustmentFactor->removeInfluenceFactor($type);
        return $this;
    }

    private function estimatePrice(?float $pricePerFunctionPoint): float {
        $this->pricePerFP = $pricePerFunctionPoint ?? $this->pricePerFP;
        $this->estimatedPrice = $this->estimatedCount * $this->pricePerFP;
        return $this->estimatedPrice;
    }

    private function estimateTime(?float $timePerFunctionPoint): int {
        $this->timePerFP = $timePerFunctionPoint ?? $this->timePerFP;
        $this->estimatedTime = $this->timePerFP * $this->estimatedCount;
        return $this->estimatedCount;
    }

    private function calculateFunctionPoints(): int {
        $count = 0;
        if (is_array($this->function) && count($this->function) > 0) {
            foreach ($this->function as $currentFunction) {
                $count += $currentFunction->getFunctionPoints();
            }
            $this->estimatedCount = $count;
        } else {
            $this->estimatedCount = 0;
        }
        $influence = $this->adjustmentFactor->getInfluenceScore();
        return $this->estimatedCount;
    }

    // Setters
    public function setAdjustmentFactors(array $influences):ICountedProject {
        if (!isset($this->adjustmentFactor)) {
            $this->adjustmentFactor = new AdjustmentFactor();
        }
        $this->adjustmentFactor->setInfluenceFactors($influences);
        return $this;
    }

    public function setprojectType(int $projectType):ICountedProject { 
        if (ProjectType::isValidValue($projectType)) {
            $this->projectType = $projectType;
        }
        return $this;       
    }
     
    public function setName(string $name):ICountedProject { 
        $this->name = $name;
        return $this; 
    }

    public function setOwner(int $id) : ICountedProject {
        $this->ownerId = $id;
        return $this;
    }

    // Getters
    public function getFunction(string $name):ICountedFunction {
        $functionName = "";
        if (is_nan($name)) {
            foreach ($this->function as $currentFunction) {
                $functionName = $currentFunction->getName();
                if (strcmp($name, $functionName)) {
                    return $currentFunction;
                }
            }
            return null; // Not found? Null is returned
        } else {
            return $this->function[$name] ?? null;
        }
    }

    public function getAllFunctions()               : array     { return $this->function; }
    public function getProjectType()                : int       { return $this->projectType; }    
    public function getEstimatedPrice()             : float     { return $this->estimatedPrice; }
    public function getEstimatedTime()              : int       { return $this->estimatedTime; }
    public function getName()                       : string    { return $this->name; }
    public function getEstimatedFunctionPoints()    : int       { return $this->estimatedCount; }
    public function getAdjustmentFactors()          : IAdjustmentFactor { return $this->adjustmentFactor; }
    public function getProjectTotalFunctionPoints() : int       { return $this->estimatedCount; }
    public function getProjectId()                  : int       { return $this->projectId; }
    public function getOwner()                      : int       { return $this->ownerId; }

    // Utilities for this class

    public function save() : ICountedProject {
        $conn = Connection::getConnection();
        if (isset($this->projectId)) {
            $sql = "UPDATE projects SET " .
                        "user_id = :owner, " .
                        "name = :name, " . 
                        "estimated_price = :price, " .
                        "estimated_count = :count, " .
                        "estimated_time = :time, " .
                        "time_per_fp = :unit_time, " .
                        "price_per_fp = :unit_price " .
                    "WHERE project_id = :id";
            $query = $conn->prepare($sql);

            $query->bindValue(":owner", $this->ownerId);
            $query->bindValue(":name", $this->name);
            $query->bindValue(":price", $this->estimatedPrice);
            $query->bindValue(":count", $this->estimatedCount);
            $query->bindValue(":time", $this->estimatedTime);
            $query->bindValue(":unit_time", $this->timePerFP);
            $query->bindValue(":unit_price", $this-);
            $query->bindValue(":id", $this->projectId);            
            $query->execute();
        } else {
            $this->create($conn);
        }
        return $this;
    }

    private function create(PDO &$conn) {
        $sql = "INSERT INTO projects (" . 
                    "user_id, " . 
                    "name, " .
                    "estimated_price, " .
                    "estimated_count, " .
                    "estimated_time, " .
                    "time_per_fp, " .
                    "price_per_fp) " .
                ") VALUES (" .
                    ":owner, " .
                    ":name, " .
                    ":price, " .
                    ":count, " .
                    ":time, " .
                    ":unit_time, " .
                    ":unit_price ";
        $query = $conn->prepare($sql);
        
        $query->bindValue(":owner", $this->ownerId);
        $query->bindValue(":name", $this->name);
        $query->bindValue(":price", $this->estimatedPrice);
        $query->bindValue(":count", $this->estimatedCount);
        $query->bindValue(":time", $this->estimatedTime);
        $query->bindValue(":unit_time", $this->timePerFP);
        $query->bindValue(":unit_price", $this-);
        $query->execute();

        $this->factorId = $conn->lastInsertId();
    }

    public function remove() {
        $conn = Connection::getConnection();

        $query = $conn->prepare("DELETE FROM projects WHERE project_id = :id");
        $query->bindValue(":id", $this->projectId);
        $query->execute();
    }
}
?>