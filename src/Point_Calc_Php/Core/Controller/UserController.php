<?php
namespace Point_Calc_Php\Core\Controller;

use Point_Calc_Php\Entities\User\IUser;
use Point_Calc_Php\Entities\User\User;

class UserController extends Controller {
    private IUser $currentUser;

    public function __construct() {
        $this->currentUser = $_SESSION['user'] !== null ? $_SESSION['user'] : new User();
    }

    public function request(string $params) {

    }

    public function insert(string $params) {
    }

    public function update(string $searchParam, string $newData) {
    }

    public function delete(string $searchParam) {
    }

    public function requestLogin() {
        $login = filter_var($_POST['login'], FILTER_SANITIZE_ENCODED);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_ENCODED);
        $user = new User();
        if ($user->logIn($login, $password)) {
            $this->currentUser = $user;
            $_SESSION['user'] = $user;
            // TODO: Redirect to logged in area
        } else {
            // TODO: Send message to front-end saying that username or password is wrong
        }
    }
}