<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:35 AM
 */

include_once __DIR__ . "/session.php";
//Defining get, post, files and request
include_once __DIR__ . "/get.php";
include_once __DIR__ . "/post.php";
include_once __DIR__ . "/request.php";
include_once __DIR__ . "/files.php";

class CoreFunctions {
    public function __construct() {
    }

    function ob_html_compress($buf) {
        return str_replace(array("\n", "\r", "\t"), '', $buf);
    }

    function loader($newrouter) {
        $output = array();
        $output["html"] = "";
        $presenturlcount = count(explode('/', $_GET["path"]));
        foreach ($newrouter->routes as $route) {
            $routerurlcount = count(explode('/', $route[0]));
            if ($presenturlcount == $routerurlcount) {
                if (substr($route[0], -1) == "*") {
                    //Matching pattern for routing
                    $match = "/" . str_replace('/*', '\/(.*)', $route[0]) . "/";
                    if (preg_match($match, $_GET["path"])) {
                        //Checking if class name and controller name is defined
                        if ($route[1] != "" && $route[2] != "") {
                            $className = $route[1];
                            //Checking if class exists
                            $this->checkclass($className);
                            $controller = new $className();
                            $controller->{$route[2]}();
                            //Checking if controller exists in the class
                            $this->checkfunction($className, $route[2]);
                            $output["html"] = $controller->HTMLFILECONTENTS;
                            $controllerarray = get_object_vars($controller);

                            //Replacing thunder with data
                            foreach ($controllerarray as $ckey => $cvar) {
                                if (!is_array($cvar) && !is_object($cvar)) {
                                    $output["html"] = str_replace("%" . $ckey . "%", $cvar, $output["html"]);
                                }
                            }
                        }else{
                            echo "No class and/or controller mentioned";
                            exit;
                        }
                        $output["routed"] = true;
                        return $output;
                    }
                } else {
                    //Matching routes directly
                    if ($route[0] == $_GET["path"]) {
                        //Checking if class name and controller name is defined
                        if ($route[1] != "" && $route[2] != "") {
                            $className = $route[1];
                            //Checking if class exists
                            $this->checkclass($className);
                            $controller = new $className();
                            //Checking if controller exists in the class
                            $this->checkfunction($className, $route[2]);
                            $controller->{$route[2]}();
                            $output["html"] = $controller->HTMLFILECONTENTS;
                            $controllerarray = get_object_vars($controller);

                            //Replacing thunder with data
                            foreach ($controllerarray as $ckey => $cvar) {
                                if (!is_array($cvar) && !is_object($cvar)) {
                                    $output["html"] = str_replace("%" . $ckey . "%", $cvar, $output["html"]);
                                }
                            }
                        }else{
                            echo "No class and/or controller mentioned";
                            exit;
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

    private function checkclass($classname) {
        //Checking if class exists
        if (!class_exists($classname)) {
            echo "Class " . $classname . " does not exist";
            exit;
        }
    }

    private function checkfunction($classname, $functionname) {
        //Checking if controller in class exists
        if (!method_exists($classname, $functionname)) {
            echo "Controller " . $functionname . " does not exist in class " . $classname;
            exit;
        }
    }
}