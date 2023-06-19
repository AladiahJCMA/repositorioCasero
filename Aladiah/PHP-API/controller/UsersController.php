<?php
declare(strict_types=1);
require_once('./model/User/UsersSQL.php');
require_once('./model/User/User.php');

class UsersController {
    private $us;
    public function __construct() {
        $this->us = new UsersSQL(ConnectionDB::connect());
    }

    public function getUser() {
        $idUser = filter_var(intval(file_get_contents('idUser')), FILTER_SANITIZE_NUMBER_INT);
        $reply = $this->us->getUser($idUser);
        echo json_encode($reply);
    }

    public function getUsers() {
        echo json_encode($this->us->getUsers());
    }

    public function registerUser() {
        $data = json_decode(file_get_contents('php://input'));
        $nUser = new User(
            intval($data->id),
            htmlspecialchars($data->username),
            filter_var($data->email, FILTER_SANITIZE_EMAIL),
            $data->password,
            $data->role,
            new DateTime('0000:00:00 00:00:00'),
            boolval($data->isPremium),
            new DateTime('0000:00:00 00:00:00'),
            boolval($data->verified)
        );

        echo json_encode($this->us->registerUser($nUser));
    }

    public function login() {
        $lUser = json_decode(file_get_contents('php://input'));
        $setCookie = file_get_contents('setCookie');
        $dbUser = $this->us->getUser($lUser->username);
        $result = password_verify($lUser->password, $dbUser->getPassword());
        $cookie = "false";
        if ($result) {
            $cookie = "true";
            if($setCookie === "true") {
                $cookie = md5(strval(random_int(169, 44444444)));
                $this->us->setCookie($dbUser->getUserId(), $cookie);
                $cookie = $cookie."%".$dbUser->getUserId();
            }
        }

        echo json_encode($cookie);
    }

    public function cookieLogin() {
        $lCookie = file('php://input'); 
        $lcArray = explode("%", $lCookie[0]);
        $reply = null;
        $try = $this->us->verifyCookie(intval($lcArray[1]), $lcArray[0]);
        if($try) {
            $reply = $this->us->getUser(intval($lcArray[1]));
        }
        echo json_encode($reply);
    }

    public function verify() {
        $vUser = json_decode(file_get_contents('php://input'));
        echo json_encode($this->us->verifyUser($vUser->id, true));
    }

    public function editUser() {
        $data = json_decode(file_get_contents('php://input'));
        $nUser = new User(
            intval($data->id),
            htmlspecialchars($data->username),
            filter_var($data->email, FILTER_SANITIZE_EMAIL),
            $data->password,
            $data->role,
            new DateTime('0000:00:00 00:00:00'),
            boolval($data->isPremium),
            new DateTime('0000:00:00 00:00:00'),
            boolval($data->verified)
        );

        echo json_encode($this->us->editUser($nUser, $nUser->getUserId()));
    }

    public function deleteUser() {
        $idUser = intval(file_get_contents('idUser'));
        
        echo json_encode($this->us->deleteUser($idUser, $idUser));
    }

    public function deleteUserAdmin() {        
        $idUser = intval(file_get_contents('idUser'));
        $idAdmin = intval(file_get_contents('idAdmin'));
        
        echo json_encode($this->us->deleteUserAdmin($idUser, $idAdmin));
    }

    public function checkUsername() {
        echo json_encode($this->us->usernameExists(
            file_get_contents('username')
        ));
    }

    public function checkEmail() {
        echo json_encode($this->us->emailExists(
            file_get_contents('email')
        ));
    }
}