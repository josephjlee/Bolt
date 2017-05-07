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
        if (USEPDO == "YES") {
            try {
                $this->conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME, USERNAME, PASSWORD);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit;
            }
        }
    }

    function __destruct() {
        if (USEPDO == "YES") {
            include_once "definations.php";
            $this->conn = null;
        }
    }

    function dataretrieve($sql) {
        $arr = array();
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $a = array();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            if ($result) {
                $a[] = $stmt->fetchAll();
            }
            $arr["result"] = "success";
            $arr["data"] = $a;
        } catch (PDOException $e) {
            $arr["result"] = "failed";
            $arr["message"] = $e->getMessage();
        }
        return $arr;
    }

    function runquery($sql) {
        $arr = array();
        try {
            // use exec() because no results are returned
            $this->conn->exec($sql);
            $arr["result"] = "success";
        } catch (PDOException $e) {
            $arr["result"] = "failed";
            $arr["message"] = $e->getMessage();
        }
        return $arr;
    }
}