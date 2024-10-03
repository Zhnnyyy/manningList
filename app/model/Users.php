<?php
class Users
{
    private $username;
    private $password;


    public function __construct(
        $data = [
            "username" => "",
            "password" => ""
        ]
    ) {
        $this->username = $data['username'];
        $this->password = $data['password'];
    }
    public function loginUser()
    {
        $response = array("Error" => false, "isValid" => false, "msg" => "haha");
        $db = new Database();
        $instance = $db::Instance();
        try {
            $instance->begin_transaction();
            $params = [$this->username, $this->password];
            $query = "select * from admin_user where admin_username = ? and admin_password = ?";
            $result = $db->_executeQuery($query, $params);
            if (!$result['Error']) {
                if ($result['length'] == 1) {
                    $response['isValid'] = true;
                    $response['id'] = $result['result'][0]['admin_id'];
                    $this->saveSession($result['result']);
                }
            } else {
                $response['Error'] = true;
                $response['msg'] = $result['result'];
            }
            $updateSession = $this->updateSession(1, $response['id']);
            if ($updateSession['Error']) {
                $instance->rollback();
                exit();
            }
            $instance->commit();
            echo json_encode($response);
        } catch (Exception $e) {
            $response['Error'] = true;
            $response['msg'] = $e->getMessage();
            echo json_encode($response);
        }
    }
    private function saveSession($data)
    {
        $_SESSION['USER'] = $data;
    }

    function updateSession($status, $uid)
    {
        $response = array("Error" => true, "msg" => "");
        $db = new Database();
        $query = "UPDATE `admin_user` SET `sess_status`= ? WHERE admin_id = ?";
        $params = [$status, $uid];
        $result = $db->_executePostQuery($query, $params);
        return $result;

    }

    public function checkSession()
    {
        $db = new Database();
        $query = "SELECT sess_status FROM `admin_user` WHERE  admin_username = ? and admin_password = ?";
        $params = [$this->username, $this->password];
        $result = $db->_executeQuery($query, $params);
        return $result['result'][0]['sess_status'];
    }
}