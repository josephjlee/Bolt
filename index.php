<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 18/04/17
 * Time: 8:57 AM
 */
include_once "core/controller.php";
include_once "definations.php";
include_once "core/AltoRouter.php";
include_once "main.php";
$core = new CoreFunctions();

if (!isset($_GET["path"])) {
    $_GET["path"] = "";
}

ob_start();
$output = $core->loader($routes);

if (isset($output["html"])) {
    echo $output["html"];
}


$finaloutput = trim(ob_get_clean());

//Compressing html output, by removing whitespace, comments etc
if(HTMLCOMPRESSION == "YES") {
    $finaloutput = $core->ob_html_compress($finaloutput);
    $finaloutput = preg_replace( '/<!--(.|\s)*?-->/' , '' , $finaloutput );
}

if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT == "YES" && !$output["routed"]) {
    header('location:http://' . ROOT . '404error');
} else {
    if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT != "YES") {
        echo "Page Error";
    } else {
        echo $finaloutput;
    }
}

