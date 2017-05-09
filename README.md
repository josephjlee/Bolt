# Bolt - A Simple PHP MVC Framework.

<b>Getting Started</b>
1. Ensure apache modrewrite is enabled on your server and AllowOveride is set to All in apache2.conf <br>
2. Change the .htaccess file's "RewriteRule ^(.*)$ /ourserverspath/index.php?path=$1 [NC,L,QSA]", Set ourserverspath to the projects directory path.<br>
3. Similarly change defination.php's "define("ROOT", "/localhost/ourlocalserverspath/")", Set ourlocalserverspath to projects path.<br>

<b>If you plan to access database</b><br>
4. Define the database information like SERVERNAME, USERNAME, PASSWORD and DBNAME in the defination.php file, if using MYSQL/MariaDB and change define("USEPDOMYSQL", "NO") to define("USEPDOMYSQL", "YES").<br>
5. Define SQLITEDBNAME in the defination.php file, if using MYSQL/MariaDB and change define("USEPDOSQLITE", "NO") to define("USEPDOSQLITE", "YES").<br>

<b>Now we are ready to run our first program.</b>
1. Create a html file in Views Folder and name it as "helloworld.html", write "%myfirstcode%" in the file and save it.<br>
2. Now in routes.php under "Define all your routes here" write "array_push($this->routes, array("", "helloworld", "helloworld"));".<br>
3. Now user_controllers.php under "Define all your controllers here" write done<br>
function helloworld(){<br>
   $this->myfirstcode = "Hi, this is a simple hello world application.";<br>
}<br>

4. Thats it. Now go to /localhost/ourserverspath/ in your favorite browser and you will see<br>
"Hi, this is a simple hello world application."<br>


