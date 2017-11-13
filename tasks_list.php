<?php
require("./lib/library.php");

$get_type = "SELECT * FROM RF_TASK_TYPE";
$get_type = $db->select($get_type);

foreach ($get_type as $key => $value) {
	$code = $value['code'];
	$param_type[$code] = $value['name'];
}

$get_sub = "SELECT * FROM RF_TASK_SUB_TYPE";
$get_sub = $db->select($get_sub);

foreach ($get_sub as $key => $value) {
	$code = $value['code'];
	$param_sub[$code] = $value['name'];
}

$get_stat = "SELECT * FROM RF_STAT";
$get_stat = $db->select($get_stat);

foreach ($get_stat as $key => $value) {
	$code = $value['code'];
	$param_stat[$code] = $value['name'];
}

?>
<!DOCTYPE HTML>
<html>
<head>
<?
include_once("head.php"); 
?>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?
		include_once("menu.php");
		?>
		<?
		include_once("header.php");
		?>
		<!-- main content start -->
		<div id="page-wrapper">
			<div class="main-page">
				
				<div class="tables">
					<h3 class="title1">Task List</h3>
					<span><a href="tasks_add.php"><i class="fa fa-plus nav_icon"></i>Add Task</a></span>
					<div class="panel-body widget-shadow">
						<table class="table table-bordered">
							<thead>
								<tr>
								  <th>#</th>
								  <th>Task Title</th>
								  <th>Type</th>
								  <th>Status</th>
								  <th>Detail</th>
								</tr>
							</thead>
							<tbody>
								<?
								$get_task = "SELECT * FROM TR_TASK WHERE stat <> 5";
								$get_task = $db->select($get_task);

								foreach ($get_task as $key => $value) {
									$task_id = $value['id'];
									$task_title = $value['title'];
									$task_stat = $value['stat'];	
									$task_type = $value['type'];	
									$task_sub_type = $value['sub_type'];	

									?>
									<tr>
									  <th scope="row"><?=$key+1;?></th>
									  <td>
								  		<span><?=$task_title;?></span>
										<br/>
										<code>
											<font style="font-size: 10px;"><?=$task_id;?></font>
										</code>
									  </td>
									  <td><?=$param_type[$task_type];?> - <?=$param_sub[$task_sub_type];?></td>
									  <td>
										<a href="tasks_detail.php?id=<?=$task_id;?>"">
											<span class="label label-primary"><?=$param_stat[$task_stat];?></span>
										</a>
									</td>
									  <td><a href="tasks_detail.php?id=<?=$task_id;?>">click here</a></td>
									</tr>
									<?
								}
								?>
								
							</tbody>
						</table>
					</div>
					
				</div>

			</div>

			</div>
		</div>
		<!-- main content end -->	
		<?
		include_once("footer.php");
		?>
	</div>
	<?
	include_once("foot.php");
	?>
</body>
</html>