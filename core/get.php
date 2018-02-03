<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:44 AM
 */

class Get {
    function __construct() {
        foreach ($_GET as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}