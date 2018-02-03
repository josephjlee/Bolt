<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:35 AM
 */

include_once __DIR__."/session.php";
//Defining get, post, files and request
include_once __DIR__."/get.php";
include_once __DIR__."/post.php";
include_once __DIR__."/request.php";
include_once __DIR__."/files.php";

class CoreFunctions {
    public function __construct() {
    }

    function ob_html_compress($buf) {
        return str_replace(array("\n", "\r", "\t"), '', $buf);
    }
    function loader($newrouter) {
        $output["html"] = "";
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
                            $output["html"] = $controller->HTMLFILECONTENTS;
                            $controllerarray = get_object_vars($controller);

                            foreach ($controllerarray as $ckey => $cvar) {
                                if (!is_array($cvar) && !is_object($cvar)) {
                                    $output["html"] = str_replace("%" . $ckey . "%", $cvar, $output["html"]);
                                }
                            }
                        }
                        $output["routed"] = true;
                        return $output;
                    }
                } else {
                    if ($route[0] == $_GET["path"]) {
                        if ($route[2] != "") {
                            $className = $route[1];
                            $controller = new $className();
                            $controller->{$route[2]}();
                            $output["html"] = $controller->HTMLFILECONTENTS;
                            $controllerarray = get_object_vars($controller);

                            foreach ($controllerarray as $ckey => $cvar) {
                                if (!is_array($cvar) && !is_object($cvar)) {
                                    $output["html"] = str_replace("%" . $ckey . "%", $cvar, $output["html"]);
                                }
                            }
                        }
                        $output["routed"] = true;
                        return $output;
                    }
                }
            }
        }
        $output["routed"] = false;
        return $output;
    }
}