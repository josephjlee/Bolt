# Bolt - A Simple PHP MVC Framework.

<b>Getting Started</b>
1. Ensure apache modrewrite is enabled on your server and AllowOveride is set to All in apache2.conf 
2. Change the .htaccess file's "RewriteRule ^(.*)$ /ourserverspath/index.php?path=$1 [NC,L,QSA]", Set ourserverspath to the projects directory path.
3. Similarly change defination.php's "define("ROOT", "/localhost/ourlocalserverspath/")", Set ourlocalserverspath to projects path.

<b>If you plan to access database</b>
4. Define all the database information like servername, username, databasename and password in the defination.php file.

<b>Now we are ready to run our first program.</b>
1. Create a html file in Views Folder and name it as "helloworld.html", write "%myfirstcode%" in the file and save it.
2. Now in routes.php under "Define all your routes here" write "array_push($this->routes, array("", "helloworld", "helloworld"));".
3. Now user_controllers.php under "Define all your controllers here" write done
function helloworld(){
   $this->myfirstcode = "Hi, this is a simple hello world application.";
}

4. Thats it. Now go to /localhost/ourserverspath/ in your favorite browser and you will see
"Hi, this is a simple hello world application."


