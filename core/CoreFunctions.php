<?php
/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 03/02/18
 * Time: 10:35 AM
 */

require_once __DIR__ . "/session.php";
//Defining get, post, files and request
require_once __DIR__ . "/get.php";
require_once __DIR__ . "/post.php";
require_once __DIR__ . "/request.php";
require_once __DIR__ . "/files.php";

class CoreFunctions {
    public function __construct() {
    }

    function ob_html_compress(string $buf): string {
        return str_replace(array("\n", "\r", "\t"), '', $buf);
    }

    function loader(array $allroutes): array {
        //Defining output
        $output = array();
        $output["html"] = "";
        $output["routed"] = false;

        //Defining alto router
        //http://altorouter.com/
        $router = new AltoRouter();
        $router->setBasePath(BASEPATH);
        foreach ($allroutes as $item) {
            try {
                $router->map($item[0], $item[1], $item[2], $item[3]);
            } catch (Exception $e) {
                echo $e;
                exit;
            }
        }
        // match current request
        $match = $router->match();
        if (isset($match['target'])) {
            $class = explode('#', $match['target'])[0];
            $function = explode('#', $match['target'])[1];
            if ($class != "" && $function != "") {
                $className = $class;
                //Checking if class exists
                $this->checkclass($className);
                $controller = new $className($router);
                $controller->{$function}();
                //Checking if controller exists in the class
                $this->checkfunction($className, $function);
                $output["html"] = $controller->HTMLFILECONTENTS;
                $controllerarray = get_object_vars($controller);

                //Replacing thunder with data
                foreach ($controllerarray as $ckey => $cvar) {
                    if (!is_array($cvar) && !is_object($cvar)) {
                        $output["html"] = str_replace("%" . $ckey . "%", $cvar, $output["html"]);
                    }
                }
            } else {
                echo "No class and/or controller mentioned";
                exit;
            }
            $output["routed"] = true;
            return $output;
        }
        return $output;
    }

    private function checkclass(string $classname) {
        //Checking if class exists
        if (!class_exists($classname)) {
            echo "Class " . $classname . " does not exist";
            exit;
        }
    }

    private function checkfunction(string $classname, string $functionname) {
        //Checking if controller in class exists
        if (!method_exists($classname, $functionname)) {
            echo "Controller " . $functionname . " does not exist in class " . $classname;
            exit;
        }
    }
}