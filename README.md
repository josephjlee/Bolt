# Bolt - A Simple PHP MVC Framework.

<b>Getting Started</b>
1. Ensure apache modrewrite is enabled on your server and AllowOveride is set to All in apache2.conf <br>
2. Similarly change defination.php's "define("BASEPATH", "/bolt")", Set our local server's path to projects path.<br>
3. Similarly change defination.php's "define("ROOT", "/localhost/ourlocalserverspath/")", Set our local server's path to projects path.<br>

<b>If you plan to access database</b><br>
4. Define the database information like SERVERNAME, USERNAME, PASSWORD and DBNAME in the defination.php file, if using MYSQL/MariaDB and change define("USEPDOMYSQL", "NO") to define("USEPDOMYSQL", "YES").<br>
5.If using SQLite define SQLITEDBNAME in the defination.php file and change define("USEPDOSQLITE", "NO") to define("USEPDOSQLITE", "YES").<br>

<b>Now we are ready to run our first program.</b>
1. Create a directory in app folder create a php file (demo.php) & html file (demo.html) <br>
2. Create a class in demo.php <br>
class DemoController extends AppController { <br>
    function __construct() { <br>
        parent::__construct(); <br>
        $this->GetHtmlFileContents('demo.html'); <br>
    } <br> <br>

    function demo() { <br>
    } <br>
} <br>
3. Write html code in demo.html <br>
4. In main.php file include the demo controller and define a demo route <br>
include_once "app/error/error.php"; <br>
array_push($routes, array('GET', "demo", "DemoController", "demo", "demopage")); <br>
5. In your browser head over to http://localhost/bolt/demo


