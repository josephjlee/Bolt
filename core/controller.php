<?php

/**
 * Created by PhpStorm.
 * User: veerajshenoy
 * Date: 20/04/17
 * Time: 9:17 AM
 */

include_once __DIR__ . "/../definations.php";
include_once __DIR__ . "/CoreFunctions.php";

//header('location:http:/'.ROOT.'pagename'); <- Use this incase session not present on to redirect to a particular page
class Controller {
    private $session;

    function __construct() {
        $this->HTMLFILECONTENTS = "";

        //Takes all the routing varibales in array, return blank if none exists
        if (isset($_GET["path"]) && $_GET["path"] != '') {
            $urlarray = explode('/', $_GET["path"]);
        } else {
            $urlarray = array();
        }

        if (isset($urlarray)) {
            $this->urlarray = $urlarray;
        } else {
            $this->urlarray = array();
        }

        //Session setup
        $this->session = new Session();

        //All the requests setup
        $this->GET = new Get();
        $this->POST = new Post();
        $this->REQUEST = new Request();
        $this->FILE = new Files();

        //Database setup
        include_once __DIR__ . "/model.php";
        $this->model = new Model();

        //Some common defaults
        $this->ROOT = "http:/" . ROOT;
        $this->APP = $this->ROOT . "app/";
        $this->ASSETS = $this->APP . "assets/";

    }

    function GetHtmlFileContents($filename) {
        //Sets HTML code to the string.
        try {
            $rc = new ReflectionClass(get_class($this));
            $this->HTMLFILECONTENTS .= file_get_contents(dirname($rc->getFileName()) . "/" . $filename);
        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }

    function GetCSSFileContents($filename) {
        //Check whether head tag is present in the DOM
        if (strpos($this->HTMLFILECONTENTS, '</head>') === false) {
            echo "no head tag found.";
            exit;
        }
        //Sets CSS code to the string before the head is closed.
        try {
            $rc = new ReflectionClass(get_class($this));
            if (is_array($filename)) {
                foreach ($filename as $item) {
                    $this->HTMLFILECONTENTS = str_replace("</head>", "<link rel='stylesheet' type='text/css' href='" . str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname($rc->getFileName()) . "/" . $item) . "'>\n</head>", $this->HTMLFILECONTENTS);
                }
            } else {
                $this->HTMLFILECONTENTS = str_replace("</head>", "<link rel='stylesheet' type='text/css' href='" . str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname($rc->getFileName()) . "/" . $filename) . "'>\n</head>", $this->HTMLFILECONTENTS);
            }

        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }

    function GetJSFileContents($filename) {
        //Check whether body tag is present in the DOM
        if (strpos($this->HTMLFILECONTENTS, '</body>') === false) {
            echo "no body tag found.";
            exit;
        }
        //Sets javascript code to the string before the body is closed.
        try {
            $rc = new ReflectionClass(get_class($this));
            if (is_array($filename)) {
                foreach ($filename as $item) {
                    $this->HTMLFILECONTENTS = str_replace("</body>", "<script src='" . str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname($rc->getFileName()) . "/" . $item) . "'></script>\n</body>", $this->HTMLFILECONTENTS);
                }
            } else {
                $this->HTMLFILECONTENTS = str_replace("</body>", "<script src='" . str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname($rc->getFileName()) . "/" . $filename) . "'></script>\n</body>", $this->HTMLFILECONTENTS);
            }
        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }

    function UploadPicture($target_dir, $filename, $minfilesize = 5000000, $renamefile = "no") {
        //Uploading picture the $filename is the name of the input tag, $target_dir is the directory where the upload is to be done,
        //$target_dir directory should be inside app directory
        //@return array of err (null if upload success) and filename as the complete path to the uploaded file
        $result = array();
        $target_dir = $this->APP . $target_dir;
        if (!file_exists($target_dir)) {
            //Create target dir if not exists
            if (is_writable($target_dir)) {
                mkdir($target_dir, 0777, true);
            } else {
                $result["err"] = "Error creating directory " . $target_dir;
                $result["filename"] = "";
                return $result;
            }
        }

        $target_dir = $target_dir . "/";

        $temp = explode(".", $this->FILE->{$filename}["name"]);
        if ($renamefile == "yes") {
            $target_file = $target_dir . round(microtime(true)) . '.' . end($temp);
        } else {
            $target_file = $target_dir . basename($this->FILE->{$filename}["name"]);
        }
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        $check = getimagesize($this->FILE->{$filename}["tmp_name"]);
        if ($check !== false) {
        } else {
            $result["err"] = "File is not an image";
            $result["filename"] = "";
            return $result;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $result["err"] = "File already exists";
            $result["filename"] = "";
            return $result;
        }

        // Check file size
        if ($this->FILE->{$filename}["size"] > $minfilesize) {
            $result["err"] = "File is too large";
            $result["filename"] = "";
            return $result;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $result["err"] = "Only JPG, JPEG, PNG and GIF allowed";
            $result["filename"] = "";
            return $result;
        }

        if (is_writable($target_dir)) {
            if (move_uploaded_file($this->FILE->{$filename}["tmp_name"], $target_file)) {
                $result["err"] = null;
                $result["filename"] = $target_file;
                return $result;
            } else {
                $result["err"] = "There was an error uploading this file";
                $result["filename"] = "";
                return $result;
            }
        } else {
            $result["err"] = $target_dir . " is not writtable.";
            $result["filename"] = "";
            return $result;
        }
    }
}