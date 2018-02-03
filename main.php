<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 01/02/18
 * Time: 4:31 PM
 */
include_once "definations.php";
include_once "routes.php";
$routes = array();

/* Define all controllers here */
include_once "app/App.php";
include_once "app/index/index.php";
include_once "app/error/error.php";


//Define all your routes here
//array_push($routes, array(route_name, controllerclass_name, controllerfunction_name ));
array_push($routes, array("", "IndexController", "index"));





//Change this is you want to point to a different controller on page not found error
// works only when PAGENOTFOUNDREDIRECT is set to YES in definations.php
if (PAGENOTFOUNDREDIRECT == "YES") {
    array_push($routes, array("404error", "ErrorController", "error"));
}