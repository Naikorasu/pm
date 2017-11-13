<?php
require("./lib/library.php");

foreach ($_REQUEST as $key => $value) {
	$$key = $value;
}

if($id == "") {
	header("location:tasks_list.php");
}

$condition =  array('id'=>$id);
$detail = "SELECT * FROM TR_TASK WHERE id = :id";
$detail = $db->select($detail,$condition);

if(count($detail) == 0) {
	header("location:tasks_list.php");
}

foreach ($detail[0] as $key => $value) {
	$$key = $value;
}

$project = "SELECT * FROM TR_PROJECT WHERE id = '$project'";
$project = $db->select($project);

foreach ($project[0] as $key => $value) {
	$var = "project_".$key;
	$$var = $value;
}

$get_user = "SELECT * FROM AUTH_USER";
$get_user = $db->select($get_user);

foreach ($get_user as $key => $value) {
	$email = $value['email'];
	$name = $value['name'];
	$param_user[$email] = $name;
}

$get_stat = "SELECT * FROM RF_STAT";
$get_stat = $db->select($get_stat);

foreach ($get_stat as $key => $value) {
	$code = $value['code'];
	$name = $value['name'];
	$param_stat[$code] = $name;
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
					<li><a href="tasks_list.php">Task List</a></li>
					<li class="active">Detail</li>
				</ol>
				
				<div class="forms">
				
					<div class="row">
						<h3 class="title1"><?=strtoupper($title);?></h3>
						<h5><?=$id;?></h5>

						<div class="form-three widget-shadow">
							<form class="form-horizontal">

								<div class="form-group">
									<label for="project" class="col-sm-2 control-label">Project</label>
									<div class="col-sm-8">
										<input readonly type="text" class="form-control1" id="project" value="<?=$project_name;?>">
										<input readonly type="text" class="form-control1" id="project_id" value="<?=$project_id;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="title" class="col-sm-2 control-label">Title</label>
									<div class="col-sm-8">
										<input readonly type="text" class="form-control1" id="title" value="<?=$title;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="description" class="col-sm-2 control-label">Description</label>
									<div class="col-sm-8">
										<textarea disabled type="text" style="height: 150px" class="form-control1" id="description"><?=$description;?></textarea>
									</div>
								</div>

								<?
								$get_img = "SELECT * FROM TR_TASK_IMG WHERE id = '$id'";
								$get_img = $db->select($get_img);
								$img = $get_img[0]['path'];
								?>

								<div class="form-group">
									<label for="description" class="col-sm-2 control-label">Screenshot</label>
									<div class="col-sm-8">
										<a href="./<?=$img;?>" target="_blank"><img src="./<?=$img;?>" width="200px" /></a>
									</div>
								</div>

								<div class="form-group">
									<label for="hashtag" class="col-sm-2 control-label">Hashtag</label>
									<div class="col-sm-8">
										<?
										$array_class = array('success', 'warning', 'danger', 'info');

										$tags = explode(",",$hashtag);
										foreach ($tags as $key => $value) {

											$label_class = $array_class[rand(0,count($array_class) - 1)];
											?>
											<span class="label label-<?=$label_class;?>"><?=$value;?></span>
											<?
										}
										?>
									</div>
								</div>

								<div class="form-group">
									<label for="init" class="col-sm-2 control-label">Init Date</label>
									<div class="col-sm-8">
										<input readonly type="text" class="form-control1" id="init" value="<?=$init;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="deadline" class="col-sm-2 control-label">Deadline Date</label>
									<div class="col-sm-8">
										<input readonly type="text" class="form-control1" id="deadline" value="<?=$deadline;?>">
									</div>
								</div>

								<?
								$percent_level_of = ($level_of + 1) / 10 * 100;

								if($percent_level_of <= 20) {

									$class = "info";
								}
								else if($percent_level_of <= 40) {

									$class = "success";
								}
								else if($percent_level_of <= 60) {
									
									$class = "warning";
								}
								else if($percent_level_of <= 100) {
									
									$class = "danger";
								}
								?>

								<div class="form-group">
									<label for="init" class="col-sm-2 control-label">Severity</label>
									<div class="col-sm-8">
										<div class="progress progress-striped active">    
											<div class="progress-bar progress-bar-<?=$class;?>" style="width: <?=$percent_level_of;?>%"></div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="user_dev" class="col-sm-2 control-label">Developed by</label>
									<div class="col-sm-8">
										<?
										$show_user_dev = $param_user[$user_dev]. " - " .$user_dev;
										?>
										<input readonly type="text" class="form-control1" id="user_qa" value="<?=$show_user_dev?>">
									</div>
								</div>

								<div class="form-group">
									<label for="user_qa" class="col-sm-2 control-label">(QA) Tested by</label>
									<div class="col-sm-8">
										<?
										$show_user_qa = $param_user[$user_qa]. " - " .$user_qa;
										?>
										<input readonly type="text" class="form-control1" id="user_qa" value="<?=$show_user_qa?>">
									</div>
								</div>

								<div class="form-group">
									<label for="stat" class="col-sm-2 control-label">Progress</label>
									<div class="col-sm-8">
										<?
										$array_class = array(
											0=>'default',
										 	1=>'warning', 
										 	2=>'success', 
										 	3=>'success', 
										 	4=>'info',
										 	5=>'primary',
										 	6=>'danger',
										 	9=>'warning',
										 );

										$label_class = $array_class[$stat];
										
										?>
										<span class="label label-<?=$label_class;?>"><?=$param_stat[$stat]?></span>
									</div>
								</div>

								<div class="form-group">
									<label for="stat" class="col-sm-2 control-label">Progress Screenshot</label>
									<div class="col-sm-8">
										<a href="tasks_progress_screenshot.php?id=<?=$id;?>">Link Screenshot</a>
									</div>
								</div>

							</form>
						</div>
					</div>

					<div class="row">

						<h3 class="title1">Update Task Progress</h3>


						<div class="form-three widget-shadow">
							<form class="form-horizontal" method="post" action="tasks_detail_process.php" enctype="multipart/form-data">

								<div class="form-group">
									<label for="task_progress" class="col-sm-2 control-label">Progress</label>
									<div class="col-sm-8">
										<div class="tables">
											<table class="table table-bordered">

												<thead>
													<tr>
													  <th><span class="label label-default">PENDING</span></th>
													  <th><span class="label label-warning">IN PROGRESS</span></th>
													  <th><span class="label label-success">DEVELOPMENT DONE</span></th>
													  <th><span class="label label-success">TESTED</span></th>
													  <th><span class="label label-info">IMPLEMENTED</span></th>
													  <th><span class="label label-primary">DONE</span></th>
													  <th><span class="label label-danger">OVERDUE</span></th>
													  <th><span class="label label-warning">CANCEL</span></th>
													</tr>
												</thead>
												<tbody>

													<?

													$pending = "";
													$in_progress = "";
													$dev_done = "";
													$tested = "";
													$implemented = "";
													$done = "";
													$overdue = "";
													$cancel = "";

													switch ($stat) {
														case 0:
															$pending = "checked";
															break;
														case 1:
															$in_progress = "checked";
															break;
														case 2:
															$dev_done = "checked";
															break;
														case 3:
															$tested = "checked";
															break;
														case 4:
															$implemented = "checked";
															break;
														case 5:
															$done = "checked";
															break;
														case 6:
															$overdue = "checked";
															break;
														case 9:
															$cancel = "checked";
															break;
														
														default:
															$pending = "";
															$in_progress = "";
															$dev_done = "";
															$tested = "";
															$implemented = "";
															$done = "";
															$overdue = "";
															$cancel = "";
															break;
													}
													?>
													<!--
													<tr style="font-size: 12px;text-align: center;">
														<td><?=$pending;?></td>
														<td><?=$in_progress;?></td>
														<td><?=$dev_done;?></td>
														<td><?=$tested;?></td>
														<td><?=$implemented;?></td>
														<td><?=$done;?></td>
														<td><?=$overdue;?></td>
														<td><?=$cancel;?></td>
													</tr>
													-->

													<tr>
														<td align="center">
															<input type="radio" <?=$pending;?> id="pending" name="task_progress" value="0">
														</td>
														<td align="center">
															<input type="radio" <?=$in_progress;?> id="in_progress" name="task_progress" value="1">
														</td>
														<td align="center">
															<input type="radio" <?=$dev_done;?> id="dev_done" name="task_progress" value="2">
														</td>
														<td align="center">
															<input type="radio" <?=$tested;?> id="tested" name="task_progress" value="3">
														</td>
														<td align="center">
															<input type="radio" <?=$implemented;?> id="implemented" name="task_progress" value="4">
														</td>
														<td align="center">
															<input type="radio" <?=$done;?> id="done" name="task_progress" value="5">
														</td>
														<td align="center">
															<input type="radio" <?=$overdue;?> id="overdue" name="task_progress" value="6">
														</td>
														<td align="center">
															<input type="radio" <?=$cancel;?> id="cancel" name="task_progress" value="9">
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

								</div>

								<div class="form-group">
									<label for="progress_desc" class="col-sm-2  control-label">Description</label> 
									<div class="col-sm-8">
										<textarea id="progress_desc" name="progress_desc" placeholder="Description" style="width:100%;"></textarea>
									</div>
								</div>

								<div class="form-group">
									<label for="progress_screenshot" class="col-sm-2  control-label">Progress Screenshot</label> 
									<div class="col-sm-8">
										<i class="fa fa-paperclip"></i>
											<input type="file" id="progress_screenshot" name="progress_screenshot" style="width:100%;">
										<p class="help-block"><font style="color:#ff0000;">Max. 32MB</font></p>
									</div>
								</div>

								<div class="form-group" align="center">
									<input type="hidden" name="task_id" value="<?=$id;?>">
									<button type="submit" class="btn btn-default">Submit</button> 
								</div>

							</form>
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