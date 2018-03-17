<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 05/05/17
 * Time: 8:39 PM
 */


//Router heavily adapted from Altorouter (https://github.com/dannyvankooten/AltoRouter)
//array_push($routes, array(REQUEST_METHOD, PATH, CONTROLLER#FUNCTION, PAGENAME));
array_push($routes, array('GET', "/", "IndexController#index", "homepage"));


class IndexController extends AppController {
    function __construct() {
        parent::__construct();
        $this->GetHtmlFileContents('index.html');
        $this->GetCSSFileContents('index.css');
        $this->GetJSFileContents(array('index.js'));
    }

    function index() {
    }

}