<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 05/05/17
 * Time: 8:39 PM
 */

class IndexController extends AppController {
    function __construct() {
        parent::__construct();
        $this->GetHtmlFileContents('./index.html');
        $this->GetCSSFileContents('./index.css');
        $this->GetJSFileContents('./index.js');
    }

    function index() {
    }

}