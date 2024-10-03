<?php

class Database
{
    private static $instance;
    static function Instance()
    {
        if (!self::$instance) {
            self::$instance = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, database: DB_NAME);
        }
        return self::$instance;
    }


    public function _executePostQuery($query, $params = [])
    {
        try {
            $stmt = $this->Instance()->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param(str_repeat("s", count($params)), ...$params);
            }
            $stmt->execute();
            return ["Error" => false, "result" => $stmt->get_result()];
        } catch (Exception $e) {
            return ["Error" => true, "result" => $e->getMessage()];
        }
    }

    public function _executeQuery($query, ...$params)
    {
        try {
            $stmt = $this->Instance()->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param(str_repeat("s", count($params[0])), ...$params[0]);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return ["Error" => false, "result" => $result->fetch_all(MYSQLI_ASSOC), "length" => $result->num_rows];
        } catch (Exception $e) {
            return ["Error" => true, "result" => $e->getMessage()];
        }
    }


    public function checkFields($keys = "")
    {
        $query = "SHOW COLUMNS FROM " . DB_NAME . "." . manningListTable;
        $result = $this->_executeQuery($query);
        // return $result['result'][0]['Field'];
        $data = [];
        foreach ($result['result'] as $row) {
            array_push($data, $row['Field']);
        }
        return $data;
    }

}