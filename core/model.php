<?php

/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 20/04/17
 * Time: 9:17 AM
 */
class Model {
    function __construct() {
        include_once __DIR__."/../definations.php";
        if (USEPDOMYSQL == "YES") {
            try {
                $this->mysql = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME, USERNAME, PASSWORD);
                // set the PDO error mode to exception
                $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit;
            }
        }

        if(USEPDOSQLITE == "YES"){
            try{
                $this->sqlite = new PDO('sqlite:'.SQLITEDBNAME);
            }catch(PDOException $e){
                echo $e->getMessage();
                exit;
            }
        }
    }

    function __destruct() {
        include_once "definations.php";
        if (USEPDOMYSQL == "YES") {
            $this->mysql = null;
        }
        if(USEPDOSQLITE == "YES"){
            $this->sqlite = null;
        }
    }

    function retrievemysql($sql) {
        $arr = array();
        try {
            $stmt = $this->mysql->prepare($sql);
            $stmt->execute();

            $a = array();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            if ($result) {
                $a = $stmt->fetchAll();
            }
            $arr["result"] = "success";
            $arr["datalenght"] = count($a);
            $arr["data"] = $a;
        } catch (PDOException $e) {
            $arr["result"] = "failed";
            $arr["message"] = $e->getMessage();
        }
        return $arr;
    }

    function runquerymysql($sql) {
        $arr = array();
        try {
            // use exec() because no results are returned
            $this->mysql->exec($sql);
            $arr["result"] = "success";
            $arr["lastinsertid"] = $this->mysql->lastInsertId();
        } catch (PDOException $e) {
            $arr["result"] = "failed";
            $arr["message"] = $e->getMessage();
        }
        return $arr;
    }

    function runquerysqlite($sql) {
        $arr = array();
        try {
            // use exec() because no results are returned
            $this->sqlite->exec($sql);
            $arr["result"] = "success";
        } catch (PDOException $e) {
            $arr["result"] = "failed";
            $arr["message"] = $e->getMessage();
        }
        return $arr;
    }

    function retrievesqlite($sql) {
        $arr = array();
        try {
            $stmt = $this->sqlite->prepare($sql);
            $stmt->execute();

            $a = array();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            if ($result) {
                $a = $stmt->fetchAll();
            }
            $arr["result"] = "success";
            $arr["datalenght"] = count($a);
            $arr["data"] = $a;
        } catch (PDOException $e) {
            $arr["result"] = "failed";
            $arr["message"] = $e->getMessage();
        }
        return $arr;
    }
}