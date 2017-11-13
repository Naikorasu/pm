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

$get_user = "SELECT * FROM AUTH_USER";
$get_user = $db->select($get_user);

foreach ($get_user as $key => $value) {
	$email = $value['email'];
	$name = $value['name'];
	$param_user[$email] = $name;
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

				<ol class="breadcrumb">
					<li><a href="index.php">Dashboard</a></li>
					<li class="active">Task List</li>
				</ol>
				
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
								  <th>Development</th>
								  <th>QA</th>
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
									$task_dev = $value['user_dev'];
									$task_qa = $value['user_qa'];
									$task_project = $value['project'];



									$project = "SELECT * FROM TR_PROJECT WHERE id = '$task_project'";
									$project = $db->select($project);

									$project_pic_email = $project[0]['pic_email'];


								  	if($user == $task_dev || $user == $task_qa || $user == $project_pic_email) {
								  		$flag = "allow";
								  	}
								  	else {
								  		$flag = "";
								  	}

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
									  <td><?=$param_sub[$task_sub_type];?><br/><?=$param_type[$task_type];?></td>
									  <td>
									  	<?=$param_user[$task_dev];?>
									  	<br/>
									  	<?=$task_dev;?>
									  </td>
									  <td>
									  	<?=$param_user[$task_qa];?>
									  	<br/>
									  	<?=$task_qa;?>
									  </td>
									  <td>
									  	<?
										$array_class = array(
											0=>'danger',
										 	1=>'warning', 
										 	2=>'warning', 
										 	3=>'success', 
										 	4=>'success',
										 	5=>'info',
										 	6=>'danger',
										 	9=>'warning',
										 );

										$label_class = $array_class[$task_stat];
										

									  	if($flag == "allow") {
									  		?>
											<a href="tasks_detail.php?id=<?=$task_id;?>"">
												<span class="label label-<?=$label_class;?>"><?=$param_stat[$task_stat];?></span>
											</a>
									  		<?
									  	}
									  	else {
									  		?>
									  		<span class="label label-<?=$label_class;?>"><?=$param_stat[$task_stat];?></span>
									  		<?
									  	}
									  	?>
									  </td>
								      <td>
								      	<?
									  	if($flag == "allow") {
									  		?>
								  			<a href="tasks_detail.php?id=<?=$task_id;?>">click here</a>
									  		<?
									  	}
									  	else {
									  	}
									  	?>
								      </td>
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