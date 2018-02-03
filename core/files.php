<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:45 AM
 */
class Files {
    function __construct() {
        foreach ($_FILES as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}