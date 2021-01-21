<?php
namespace Point_Calc_Php\Entities\User;

class User implements IUser {
    private string $name;
    private string $login;
    private float $pricePerFunctionPoint;
    private float $timePerFunctionPoint;
    private int $userId;
    private bool $loggedIn = false;

    public function getName()  { return $this->name;  }
    public function getLogin() { return $this->login; }
    public function getPricePerFunctionPoint() { return $this->pricePerFunctionPoint; }
    public function getTimePerFunctionPoint()  { return $this->timePerFunctionPoint;  }

    public function setName(string $name) { 
        $this->name = $name;
        $this->persist(); 
    }
    public function setLogin(string $login) { 
        $this->login = $login;
        $this->persist(); 
    }
    public function setPassword(string $password) { 
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->persist(); 
    }
    public function setPricePerFunctionPoint(float $value) { 
        $this->pricePerFunctionPoint = $value;
        $this->persist(); 
    }
    public function setTimePerFunctionPoint(float $estimate) { 
        $this->timePerFunctionPoint = $estimate;
        $this->persist(); 
    }

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

    private function persist() {}
}


?>