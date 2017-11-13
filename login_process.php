<?php
require("./lib/library.php");

$fn->dump($_REQUEST);

$mail = $_REQUEST['email'];
$pwd = md5($_REQUEST['password']);

$condition = array("email"=>$mail,"pwd"=>$pwd);
$auth_user = $db->select("SELECT * FROM AUTH_USER WHERE email=:email AND password=:pwd",$condition);

$fn->dump($auth_user);

$_SESSION['0c83f57c786a0b4a39efab23731c7ebc'] = $auth_user[0]['email'];
$_SESSION['b068931cc450442b63f5b3d276ea4297'] = $auth_user[0]['name'];


if($db->RR == 1) {	
	header("location:index.php");	
}
else {
	header("location:login.php?err=email%20and%20password%20not%20valid.");
}


?>