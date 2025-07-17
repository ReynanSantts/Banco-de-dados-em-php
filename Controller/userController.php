<?php

namespace Controller;

use Model\User;
use Exception;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    //Registro de Usuario
    public function registerUser($user_fullname, $email, $password)
    {
        try {

            if (empty($user_fullname) or empty($email) or empty($password)) {
                return false;
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            return $this->userModel->registerUser($user_fullname, $email, $hashedPassword);
        } catch (Exception $e) {
            echo "Erro ao cadastrar usuario:" . $e->getMessage();
            return false;
        }
    }
    //E-mail ja cadastrado?
    public function checkUserByEmail($email){
        return $this->userModel->getUserByEmail($email);
    }

    //Login de Usuario
    public function login($email, $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        /* $user = [
            "id" => 1,
            "user_fullname" => "Teste"
            "email" => "reynan@example.com"
            "password" => "......"
            ]
        */

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['user_fullname'] = $user['user_fullname'];
            $_SESSION['email'] = $user['email'];
        }
        return false;
    }

    //Usuario logado?
    public function isLoggedIn(){
        return isset($_SESSION['id']);
    }

    //Resgatar dados do usuario
    public function getUserData($id,$user_fullname, $email){
        $id = $_SESSION['id'];

        return $this->userModel->getUserInfo($id,$user_fullname, $email);
    }
}
?>