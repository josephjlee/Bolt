<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:44 AM
 */

class Request {
    function __construct() {
        foreach ($_REQUEST as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}