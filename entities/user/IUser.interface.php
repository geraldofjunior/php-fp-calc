<?php
namespace Point_Calc_Php\Entities\User;

interface IUser {
    public function getName();
    public function getLogin();
    public function getPricePerFunctionPoint();
    public function getTimePerFunctionPoint();

    public function setName(string $name);
    public function setLogin(string $login);
    public function setPassword(string $password);
    public function setPricePerFunctionPoint(float $value);
    public function setTimePerFunctionPoint(float $estimate);

    public function isLoggedIn();
    public function logIn(string $login, string $password);
    public function logOut();
}
?>