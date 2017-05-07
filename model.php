<?php

/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 20/04/17
 * Time: 9:17 AM
 */
class Model {
    function __construct() {
        include_once "definations.php";
        // Create connection
        $this->conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
        // Check connection
        if ($this->conn->connect_error) {
            //die("Connection failed: " . $conn->connect_error);
            $data = array("resp" => "failed", "error" => $this->conn->connect_error);
        }
    }

    function __destruct() {
        $this->conn->close();
    }

    function dataretrieve($sql) {
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $result[] = $row;
            }
            $arr["result"] = count($result);
            $arr["data"] = $result;
        } else {
            $arr["result"] = 0;
        }
        return $arr;
    }

    function runquery($sql) {
        if ($this->conn->query($sql) === TRUE) {
            $arr["result"] = "success";
        } else {
            $arr["result"] = "failed";
        }
        return $arr;
    }
}