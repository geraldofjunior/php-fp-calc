<?php
namespace Point_Calc_Php\Entities\User;

use DateTime;

interface IUser {
    public function getName() : string;
    public function getLogin() : string;
    public function getPricePerFunctionPoint() : float;
    public function getTimePerFunctionPoint() : float;
    public function getPlan() : int;
    public function getPlanDue() : DateTime;

    public function setName(string $name) : IUser;
    public function setLogin(string $login) : IUser;
    public function setPassword(string $password) : IUser;
    public function setPricePerFunctionPoint(float $value) : IUser;
    public function setTimePerFunctionPoint(float $estimate) : IUser;
    public function setPlan(int $plan) : IUser;
    public function setPlanDue(DateTime $due) : IUser;

    public function isLoggedIn() : bool;
    public function logIn(string $login, string $password) : bool;
    public function logOut() : void;
}