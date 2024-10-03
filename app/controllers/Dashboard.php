<?php

class Dashboard extends Controller
{
    public function index()
    {

        if (!isset($_SESSION['USER'])) {
            header("location:/manninglist/public");
        }

        $data['header'] = true;
        $data['footer'] = true;
        $data['title'] = "Dashboard | Manninglist";
        $data['styles'] = ['<link rel="stylesheet" href="' . ROOT_CSS . 'dashboard.css">'];
        $data['script'] = ['<script src="' . ROOT_JS . 'xlsx.full.min.js"></script>'];
        $data['employee'] = Employee::allEmployee();
        $this->view('/dashboard', $data);
    }


    public function import()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require "../app/view/404.view.php";
        }
        $jsonData = file_get_contents("php://input");
        $POST = json_decode($jsonData, true);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            var_dump($_POST);

            // $result = Employee::importEmployees(json_decode($_POST['employees'], true));
            // // $result = Employee::importEmployees($POST['employees']);
            // echo $result;
        }
        exit();
    }


    public function logout()
    {
        // var_dump($_SESSION);
        $user = new Users();
        $result = $user->updateSession(0, $_SESSION['USER'][0]['admin_id']);
        // var_dump($result['result']);
        if (!$result['Error'] && !$result['result']) {
            session_start();
            session_unset();
            session_destroy();
            header("location:/manninglist/public/");
        }
        exit();
    }

    public function checkFields()
    {
        $db = new Database();
        $columns = $db->checkFields();
    }



}