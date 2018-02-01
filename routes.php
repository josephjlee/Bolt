<?php

/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 20/04/17
 * Time: 8:55 AM
 */

/* Define all controllers here */
include_once "app/index/index.php";
include_once "app/error/error.php";

//Route will work without controller but view is compulsory
class router {
    function __construct() {
        include_once "definations.php";

        $this->routes = array();
        //Define all your routes here
        //array_push($this->routes, array(route_name, controllerfunction_name, viewfunction_name, controllerclass_name));
        array_push($this->routes, array("", "IndexController", "index"));

        if (PAGENOTFOUNDREDIRECT == "YES") {
            array_push($this->routes, array("404error", "ErrorController", "error"));
        }

        //End of all routes definitions
        $this->checkduplicate($this->routes);
    }

    function checkduplicate($array) {
        $elementarray = array();

        foreach ($array as $arr) {
            $elementarray[] = $arr[0];
        }
        foreach (array_count_values($elementarray) as $key => $value) {
            if ($value == 2) {
                echo "Route has redundant value of " . $key . ". Please Check the routing contructor.";
                exit;
            }
        }

    }
}