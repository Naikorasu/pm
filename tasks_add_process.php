<?php
require("./lib/library.php");

$fn->dump($_REQUEST);
$fn->dump($_FILES["task_screen_shot"]);

$uploaded = $_FILES["task_screen_shot"];

foreach ($_REQUEST as $key => $value) {
	$$key = $value;
}

$user = $_SESSION['0c83f57c786a0b4a39efab23731c7ebc'];

$id = md5($task_project.$task_title.$user.microtime());
$modified = date('d/m/Y');

$insert_data = array(
	'id'=>$id,
	'project'=>$task_project,
	'title'=>$task_title,
	'type'=>$task_type,
	'sub_type'=>$task_sub_type,
	'level_of'=>$task_level,
	'user_dev'=>$task_dev,
	'user_qa'=>$task_qa,
	'description'=>$task_desc,
	'hashtag'=>$hashtag,
	'deadline'=>$task_deadline,
	'stat'=>0,
	'modified'=>$modified,
);
$insert_table = "TR_TASK";

$image_id = md5($uploaded['name'].$uploaded['size'].$uploaded['type'].$user.microtime());

$target_dir = "task_data/";
$target_file = $target_dir . $image_id;

$imageFileType = pathinfo($uploaded['name'],PATHINFO_EXTENSION);

$image_table = "TR_TASK_IMG";
$image_data = array(
	'id'=>$id,
	'img_id'=>$image_id,
	'type'=>$imageFileType,
	'path'=>$target_file,
);

$fn->dump($insert_data);
$fn->dump($image_data);

try {

	if (move_uploaded_file($uploaded["tmp_name"], $target_file)) {

		$db->insert($insert_table,$insert_data);
		$db->insert($image_table,$image_data);

		header("location:tasks_list.php");

	} else {
		echo "<script>";
		echo "alert('UPLOAD FILE FAILED')";
		echo "</script>";
	}
}
catch(Exception $e) {
		$msg = $e->getMessage();

		echo "<script>";
		echo "alert('UPLOAD FILE FAILED\\n".$msg."')";
		echo "</script>";
}
?>