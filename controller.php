<?php

/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 20/04/17
 * Time: 9:17 AM
 */
//header('location:http:/'.ROOT.'pagename'); <- Use this incase session not present on to redirect to a particular page
class Controller {
    private $session;

    function __construct() {
        include_once "definations.php";
        if (isset($urlarray)) {
            $this->urlarray = $urlarray;
        } else {
            $this->urlarray = array();
        }
        $this->session = new Session();
        $this->get = new Get();
        $this->post = new Post();
        $this->request = new Request();

        include_once "user_model.php";
        $this->model = new UserModel();

        //Some common defaults

    }
}
