<?php

class Employee
{

    static function allEmployee()
    {
        $db = new Database();
        $query = "SELECT A.emp_id, A.emp_fname, A.emp_mname, A.emp_lname, A.emp_sfname, A.emp_status, A.emp_created, A.assignment, A.emp_position, B.id, B.region, B.rate  FROM employee_tbl as A INNER JOIN region as B ON B.id = A.region order by A.emp_id DESC";
        return $db->_executeQuery($query);
    }


    static function importEmployees($employee)
    {
        $response = array("Error" => true);
        $db = new Database();
        $instance = $db::Instance();
        try {
            $instance->begin_transaction();
            $add_Status = 1;
            $add_Created = date("Y-m-d");
            foreach ($employee as $val) {
                $curr_region = self::getRegionID($val['region']);
                $params = [$val['emp_Id'], $val['firstName'], $val['middleName'], $val['lastName'], $curr_region, $val['assignment'], $val['position'], $add_Status, $add_Created];
                $query = "insert into employee_tbl (emp_number, emp_fname, emp_mname, emp_lname, region, assignment, emp_position, emp_status, emp_created) values(?,?,?,?,?,?,?,?,?)";
                if (!self::checkDuplicate($val['emp_Id'])) {
                    $db->_executePostQuery($query, $params);
                }
            }

            //logs
            $query = "INSERT INTO `admin_editlog`(`log_action`, `log_user`) VALUES (?,?)";
            $param = ["Import Excel file", $_SESSION['USER'][0]['admin_username']];
            $result = $db->_executePostQuery($query, $param);
            if ($result['Error']) {
                $instance->rollback();
                return $result;
            }
            $instance->commit();
            $response["Error"] = false;
            $response["msg"] = "Employees Imported Successfully";
            return json_encode($response);
        } catch (Exception $e) {
            $instance->rollback();
            $response['Error'] = true;
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        }
    }




    // Get the ID of region base on the given value
    private static function getRegionID($regionName)
    {
        $db = new Database();
        $result = $db->_executeQuery("select id from region where region='$regionName'");
        return $result['result'][0]['id'];
    }


    //  Check if the employee ID already exist in the database
    private static function checkDuplicate($emp_number)
    {
        $db = new Database();
        $result = $db->_executeQuery("select emp_id from employee_tbl where emp_number='$emp_number'");
        return $result['length'] == 1 ? true : false;

    }


}