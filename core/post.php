<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:44 AM
 */


class Post {
    function __construct() {
        foreach ($_POST as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }
}