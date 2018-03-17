<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 01/02/18
 * Time: 4:26 PM
 */


//Router heavily adapted from Altorouter (https://github.com/dannyvankooten/AltoRouter)
//array_push($routes, array(REQUEST_METHOD, PATH, CONTROLLER#FUNCTION, PAGENAME));
// works only when PAGENOTFOUNDREDIRECT is set to YES in definations.php
if (PAGENOTFOUNDREDIRECT == "YES") {
    array_push($routes, array('GET', "/404error", "ErrorController#error", "errorpage"));
}


class ErrorController extends AppController {
    function __construct() {
        parent::__construct();
        $this->GetHtmlFileContents('./error.html');
    }

    function error() {
    }

}