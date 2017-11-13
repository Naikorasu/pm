<?php
require("./lib/library.php");

$fn->dump($_REQUEST);
$fn->dump($_FILES["progress_screenshot"]);

$uploaded = $_FILES["progress_screenshot"];

foreach ($_REQUEST as $key => $value) {
	$$key = $value;
}

$progress_id = md5($task_id.$task_progress.$user.microtime());
$modified = date('Y/m/d h:i:s');

$update_table = "TR_TASK";
$update_data = array(
	'stat'=>$task_progress,
	'modified'=>$modified,
);
$update_condition = array('id'=>$task_id);

$image_id = md5($uploaded['name'].$uploaded['size'].$uploaded['type'].$user.microtime());

$target_dir = "task_progress/";
$target_file = $target_dir . $image_id;

$imageFileType = pathinfo($uploaded['name'],PATHINFO_EXTENSION);

$progress_table = "TR_TASK_PROGRESS";
$progress_data = array(
	'id'=>$progress_id,
	'task_id'=>$task_id,
	'progress_stat'=>$task_progress,
	'img_path'=>$target_file,
	'type'=>$imageFileType,
	'description'=>$progress_desc,
);


try {

	if (move_uploaded_file($uploaded["tmp_name"], $target_file)) {

		$db->update($update_table,$update_data,$update_condition);
		$db->insert($progress_table,$progress_data);

		header("location:tasks_detail.php?id=$task_id");

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