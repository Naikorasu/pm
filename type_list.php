<?php
require("./lib/library.php");

$condition = array('type'=>$_REQUEST['t']);

$get_sub_type = "SELECT * FROM RF_TASK_SUB_TYPE WHERE type = :type";
$get_sub_type = $db->select($get_sub_type,$condition);

?>

<label for="task_sub_type">Task Sub Type</label>
<select class="form-control" id="task_sub_type" name="task_sub_type">
	<?
	foreach ($get_sub_type as $key => $value) {
		?>
		<option value="<?=$value['code'];?>"><?=$value['name'];?></option>
		<?
	}
	?>
</select>