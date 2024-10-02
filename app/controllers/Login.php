<?php

class Login extends Controller
{

    public function index()
    {

        $data['title'] = "Login | Manninglist";
        $data['styles'] = ["<link rel='stylesheet' href='" . ROOT_CSS . "login.css'>"];
        $this->view('/login', $data);
    }

    public function login()
    {
        echo 'login method';
    }
}