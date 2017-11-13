<?php
require("./lib/library.php");

foreach ($_REQUEST as $key => $value) {
	$$key = $value;
}

$time = microtime();

$id = md5($project_name.$project_pic.$time);

$array_insert = array(
	'id'=>$id,
	'name'=>$project_name,
	'pic_email'=>$project_pic,
);

$table_insert = "TR_PROJECT";

$db->insert($table_insert,$array_insert);

header("location:projects_list.php");

?>