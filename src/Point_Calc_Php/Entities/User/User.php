<?php
namespace Point_Calc_Php\Entities\User;

use DateTime;
use Point_Calc_Php\Core\Services\Database\Connection;

use PDO;

class User implements IUser {
    private string $name;
    private string $login;
    private string $password;
    private float $pricePerFunctionPoint;
    private float $timePerFunctionPoint;
    private int $userId;
    private int $plan;
    private DateTime $planDue;
    private bool $loggedIn = false;

    public function getName()  { return $this->name;  }
    public function getLogin() { return $this->login; }
    public function getPricePerFunctionPoint() { return $this->pricePerFunctionPoint; }
    public function getTimePerFunctionPoint()  { return $this->timePerFunctionPoint;  }

    

    public function isLoggedIn() {
        return $this->loggedIn;
    }

    public function logIn(string $login, string $password) {
        // TODO: Implement an actual username/password query
        // TODO: Implement a moment where this method actually fills this object
        $this->loggedIn = true;
    }
    public function logOut() {
        $this->loggedIn = false;
    }

    // Setters

    public function setName(string $name) { 
        $this->name = $name;
        return $this;
    }

    public function setLogin(string $login) { 
        $this->login = $login;
        return $this;
    }
    public function setPassword(string $password) { 
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this; 
    }
    public function setPricePerFunctionPoint(float $value) { 
        $this->pricePerFunctionPoint = $value;
        return $this; 
    }
    public function setTimePerFunctionPoint(float $estimate) { 
        $this->timePerFunctionPoint = $estimate;
        return $this; 
    }

    public function setPlan(int $plan) {
        $this->plan = $plan;
        return $this;
    }

    public function setPlanDue(DateTime $planDue) {
        $this->planDue = $planDue;
        return $this;
    }

    // Getters

    // Utilities for this class

    public function save() : IUser {
        $conn = Connection::getConnection();
        if (isset($this->userId)) {
            $sql = "UPDATE users SET " .
                        "name = :name, " . 
                        "login = :login" . 
                        "password = :password" . 
                        "default_time_per_fp = :unit_time, " .
                        "default_price_per_fp = :unit_price " .
                    "WHERE user_id = :id";
            $query = $conn->prepare($sql);
            $query->bindValue("name", $this->name);
            $query->bindValue("login", $this->login);
            $query->bindValue("password", $this->password);
            $query->bindValue("unit_time", $this->timePerFunctionPoint);
            $query->bindValue("unit_price", $this->pricePerFunctionPoint);
            $query->execute();
        } else {
            $this->create($conn);
        }
        return $this;
    }

    private function create(PDO &$conn) {
        $sql = "INSERT INTO users (" . 
                    "name, " .
                    "estimated_price, " .
                    "estimated_count, " .
                    "estimated_time, " .
                    "time_per_fp, " .
                    "price_per_fp, " .
                    "created, " .
                    "login_number, " . 
                    "plan, " .
                    "plan_due" .
                ") VALUES (" .
                    ":owner, " .
                    ":name, " .
                    ":price, " .
                    ":count, " .
                    ":time, " .
                    ":unit_time, " .
                    ":unit_price, " .
                    ":now, " .
                    "0, 0, null";
        $query = $conn->prepare($sql);
        
        $query->bindValue(":owner", $this->ownerId);
        $query->bindValue(":name", $this->name);
        $query->bindValue(":price", $this->estimatedPrice);
        $query->bindValue(":count", $this->estimatedCount);
        $query->bindValue(":time", $this->estimatedTime);
        $query->bindValue(":unit_time", $this->timePerFP);
        $query->bindValue(":unit_price", $this->pricePerFP);
        $query->bindValue(":now", date("Y-m-d H:i:s"));
        $query->execute();

        $this->userId = $conn->lastInsertId();
    }

    public function remove() {
        $conn = Connection::getConnection();

        $query = $conn->prepare("DELETE FROM projects WHERE project_id = :id");
        $query->bindValue(":id", $this->projectId);
        $query->execute();
    }
}


?>