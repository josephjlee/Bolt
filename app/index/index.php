<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 05/05/17
 * Time: 8:39 PM
 */

class IndexController extends Controller {

    //Define all your controllers here
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->GetHtmlFileContents('./index.html');
    }

}