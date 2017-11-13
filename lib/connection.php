<?php
require("database.php");

$db_type = "mysql";
$db_host = "127.0.0.1";
$db_name = "db_project_management";
$db_port = "3306";
$db_user = "root";
$db_pass = "";


$db = new database();
$db->construct($db_type, $db_host, $db_name, $db_port, $db_user, $db_pass);
//$db->information();
?>