<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'mysql-mqssi.alwaysdata.net');
define('DB_USERNAME', 'mqssi');
define('DB_PASSWORD', 'mqssi');
define('DB_NAME', 'mqssi_project');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERREUR: Requête impossible. (Error code : #1)" . mysqli_connect_error());
}
?>