<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 18/04/17
 * Time: 8:57 AM
 */
include_once "controller.php";
include_once "main.php";

if (!isset($_GET["path"])) {
    $_GET["path"] = "";
}

ob_start();
$output = loader($run);

if (isset($output)) {
    echo $output;
}


$finaloutput = trim(ob_get_clean());

//Compressing html output, by removing whitespace, comments etc
if(HTMLCOMPRESSION == "YES") {
    $finaloutput = ob_html_compress($finaloutput);
    $finaloutput = preg_replace( '/<!--(.|\s)*?-->/' , '' , $finaloutput );
}

if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT == "YES") {
    header('location:http:/' . ROOT . '404error');
} else {
    if ($finaloutput == "" && null !== PAGENOTFOUNDREDIRECT && PAGENOTFOUNDREDIRECT != "YES") {
        echo "Page Error";
    } else {
        echo $finaloutput;
    }
}

function ob_html_compress($buf){
    return str_replace(array("\n","\r","\t"),'',$buf);
}

function loader($newrouter) {
    $output = "";
    $presenturlcount = count(explode('/', $_GET["path"]));
    foreach ($newrouter->routes as $route) {
        $routerurlcount = count(explode('/', $route[0]));
        if ($presenturlcount == $routerurlcount) {
            if (substr($route[0], -1) == "*") {
                $match = "/" . str_replace('/*', '\/(.*)', $route[0]) . "/";
                if (preg_match($match, $_GET["path"])) {
                    if ($route[2] != "") {
                        $className = $route[1];
                        $controller = new $className();
                        $controller->{$route[2]}();
                        $output = $controller->HtmlFileContents;
                        $controllerarray = get_object_vars($controller);

                        foreach ($controllerarray as $ckey => $cvar) {
                            if (!is_array($cvar) && !is_object($cvar)) {
                                $output = str_replace("%" . $ckey . "%", $cvar, $output);
                            }
                        }
                    }
                    return $output;
                }
            } else {
                if ($route[0] == $_GET["path"]) {
                    if ($route[2] != "") {
                        $className = $route[1];
                        $controller = new $className();
                        $controller->{$route[2]}();
                        $output = $controller->HtmlFileContents;
                        $controllerarray = get_object_vars($controller);

                        foreach ($controllerarray as $ckey => $cvar) {
                            if (!is_array($cvar) && !is_object($cvar)) {
                                $output = str_replace("%" . $ckey . "%", $cvar, $output);
                            }
                        }
                    }
                    return $output;
                }
            }
        }
    }
    return $output;
}