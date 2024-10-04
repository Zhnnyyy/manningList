<?php

class Employee
{

    static function allEmployee()
    {
        $db = new Database();
        $fields = $db->checkFields();
        $acceptedFields = ["Name"];
        $employee = [];

        foreach ($fields as $val) {
            if ($val != "emp_id" && $val != "emp_created" && $val != "emp_timestamp" && $val != "FirstName" && $val != "MiddleName" && $val != "LastName") {
                $acceptedFields[] = $val == "emp_status" ? "Status" : $val;
                $employee[] = $val;
            }
        }

        $query = "select concat(LastName,', ', FirstName, ' ', MiddleName) as Name," . implode(", ", $employee) . " from employee_tbl order by IdNumber desc";
        $result = $db->_executeQuery($query);
        return ["headers" => $acceptedFields, "employee" => $result['result']];
    }


    static function importEmployees_old($employee)
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


    static function importEmployees($employee)
    {
        $response = array("Error" => true);
        $add_Status = 1;
        $add_Created = date("Y-m-d");
        $db = new Database();
        $instance = $db::Instance();
        try {
            $instance->begin_transaction();
            foreach ($employee as $val) {
                $keys = array_keys($val);
                $values = array_values($val);
                $params = [$add_Status, $add_Created];
                $column = ["emp_status", "emp_created"];
                $qmark = ["?", "?"];
                for ($i = 0; $i < count($keys); $i++) {
                    $params[] = $values[$i];
                    $column[] = $keys[$i];
                    $qmark[] = "?";
                }
                // var_dump($qmark);
                $query = "insert into employee_tbl (" . implode(",", $column) . ") values(" . implode(",", $qmark) . ")";
                $index = array_search("IdNumber", $keys);
                $idNumber = $values[$index];

                if (!self::checkDuplicate($idNumber)) {
                    $insert = $db->_executePostQuery($query, $params);
                    if ($insert['Error']) {
                        $instance->rollback();
                        $response['Error'] = true;
                        $response['msg'] = $insert['result'];
                        return json_encode($response);
                    }
                }
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


    //Add dynamic column directly in database
    static function alterDynamicTable($headers)
    {
        $db = new Database();
        $columnName = [];
        foreach ($headers as $val) {
            $columnName[] = "ADD COLUMN {$val} varchar(255)";
        }
        $tbl = "ALTER TABLE employee_tbl " . implode(", ", $columnName);
        $query = rtrim($tbl, ",");
        $result = $db->_executePostQuery($query);
        return $result;

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
        $result = $db->_executeQuery("select * from employee_tbl where IdNumber='$emp_number'");
        // return $result;
        return $result['length'] == 1 ? true : false;

    }
}