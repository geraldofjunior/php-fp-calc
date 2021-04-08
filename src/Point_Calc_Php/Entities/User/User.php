<?php
namespace Point_Calc_Php\Entities\User;

use DateTime, Exception;
use Point_Calc_Php\Core\Services\Database\Connection;
use function PHPUnit\Framework\throwException;

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

    public function getName() : string  { return $this->name;  }
    public function getLogin() : string { return $this->login; }
    public function getPricePerFunctionPoint() : float { return $this->pricePerFunctionPoint; }
    public function getTimePerFunctionPoint() : float  { return $this->timePerFunctionPoint;  }
    public function getPlan(): int { return $this->plan; }
    public function getPlanDue(): DateTime { return $this->planDue; }
    public function isLoggedIn() : bool { return $this->loggedIn; }

    public function logIn(string $login, string $password) : bool {
        $login_info = [ 'login' => $login, 'password' => password_hash($password, PASSWORD_DEFAULT)];
        $conn = Connection::getConnection();
        $result = $conn->load("users", null, $login_info);
        if (sizeof($result) == 0 || $result == false) {
            $this->loggedIn = false;
            return false;
        }
        try {
            $this->setLogin($login)
                ->setPassword($password)
                ->setName($result[0]['name'])
                ->setPlan($result[0]['plan'])
                ->setPlanDue(new DateTime($result[0]['plan_due']))
                ->setTimePerFunctionPoint($result[0]['default_time_per_fp'])
                ->setPricePerFunctionPoint($result[0]['default_price_per_fp']);
        } catch (Exception $e) {
            throwException($e);
        }
        return $this->loggedIn;
    }
    public function logOut() : void {
        $this->loggedIn = false;
    }

    // Setters

    public function setName(string $name) : IUser {
        $this->name = $name;
        return $this;
    }

    public function setLogin(string $login) : IUser {
        $this->login = $login;
        return $this;
    }
    public function setPassword(string $password) : IUser {
        $this->password = password_hash($password, PASSWORD_DEFAULT) ?? $this->password;
        return $this;
    }
    public function setPricePerFunctionPoint(float $value) : IUser {
        $this->pricePerFunctionPoint = $value;
        return $this; 
    }
    public function setTimePerFunctionPoint(float $estimate) : IUser {
        $this->timePerFunctionPoint = $estimate;
        return $this; 
    }

    public function setPlan(int $plan) : IUser {
        $this->plan = $plan;
        return $this;
    }

    public function setPlanDue(DateTime $due) : IUser {
        $this->planDue = $due;
        return $this;
    }

    // Utilities for this class

    public function save() : IUser
    {
        $conn = Connection::getConnection();
        $data = ['name' => $this->name,
            'login' => $this->login,
            'password' => $this->password,
            'default_time_per_fp' => $this->timePerFunctionPoint,
            'default_price_per_fp' => $this->pricePerFunctionPoint,
            'plan' => $this->plan,
            'plan_due' => date_format($this->planDue, "YYYY-mm-dd hh:mm:ss")
        ];
        if (isset($this->userId)) {
            $condition = ['user_id' => $this->userId];
            $conn->save("users", $data, $condition);
        } else {
            $this->userId = $conn->create('users', $data);
        }
        return $this;
    }

    public function remove() {
        $conn = Connection::getConnection();
        $condition = [ 'user_id' => $this->userId ];
        $conn->delete('users', $condition);
    }
}