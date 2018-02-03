<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:43 AM
 */

//Defining sessions in class
class Session {
    function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        foreach ($_SESSION as $skey => $svalue) {
            $this->{$skey} = $svalue;
        }
    }

    function setsessionkey($key, $value) {
        $_SESSION[$key] = $value;
        $this->{$key} = $value;
    }

    function destroysessionkey($key) {
        unset($_SESSION[$key]);
        unset($this->{$key});
    }

    function destroyall() {
        foreach ($_SESSION as $skey => $svalue) {
            unset($_SESSION[$skey]);
            unset($this->{$skey});
        }
        session_destroy();
    }
}