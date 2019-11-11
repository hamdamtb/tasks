<?php

class Users extends Controller {

    function loginAction () {
        if (!isset($_SESSION['is_logged'])) {
            if(empty($_POST)){
                $this->view('login');
                return;
            }
            $params = $_POST;
            if(isset($params["login"]) && $params["login"] === "admin" && isset($params["password"]) && $params["password"] === "123"){
                $_SESSION['is_logged'] = 1;
                header('Location: /');
            } else {
                $this->view('login', ["form_data" => $params, "error_message" => "Логин или пароль не правыльно."]);
            }
        } else {
            header('Location: /');
        }
    }

    function logOutAction(){
        if(isset($_SESSION["is_logged"])){
            unset($_SESSION["is_logged"]);
        }
        header('Location: /');
    }

}

?>