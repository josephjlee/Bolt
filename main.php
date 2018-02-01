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
include_once "app/index/index.php";
include_once "app/error/error.php";


//Define all your routes here
//array_push($routes, array(route_name, controllerfunction_name, viewfunction_name, controllerclass_name));
array_push($routes, array("", "IndexController", "index"));

if (PAGENOTFOUNDREDIRECT == "YES") {
    array_push($routes, array("404error", "ErrorController", "error"));
}









$run = new router($routes);