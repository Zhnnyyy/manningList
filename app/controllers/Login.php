<?php

class Login extends Controller
{

    public function index()
    {
        if (isset($_SESSION['USER'])) {
            header("location:/manninglist/public/dashboard");
        }
        $data['header'] = false;
        $data['footer'] = false;
        $data['title'] = "Login | Manninglist";
        $data['styles'] = ["<link rel='stylesheet' href='" . ROOT_CSS . "login.css'>"];
        $this->view('/login', $data);
    }

    public function helloworld()
    {
        echo "Hello World";
        exit();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require "../app/view/404.view.php";
        }
        $jsonData = file_get_contents("php://input");
        $POST = json_decode($jsonData, true);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new Users($_POST);
            if (!$user->checkSession()) {
                $user->loginUser();
            } else {
                echo json_encode(array("Error" => true, "msg" => "User still have active session"));
                exit();
            }
        }

    }
}