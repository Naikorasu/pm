<?php
require("./lib/library.php");

$total_task = "SELECT COUNT(*) as total_task FROM TR_TASK 
WHERE stat <> 5";
$total_task = $db->select($total_task);
$total_task = $total_task[0]['total_task'];


$total_request = "SELECT COUNT(*) as total_request FROM TR_TASK 
WHERE type = 'REQUEST' 
AND stat <> 5";
$total_request = $db->select($total_request);
$total_request = $total_request[0]['total_request'];


$total_issue = "SELECT COUNT(*) as total_issue FROM TR_TASK 
WHERE type = 'ISSUE' 
AND stat <> 5";
$total_issue = $db->select($total_issue);
$total_issue = $total_issue[0]['total_issue'];

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
				
				<div class="row-one">

					<div class="col-md-2 widget">
						<div class="stats-left ">
							<h5>Total</h5>
							<h4>Tasks</h4>
						</div>
						<div class="stats-right">
							<label> <?=$total_task;?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>

					<div class="col-md-2 widget states-mdl">
						<div class="stats-left">
							<h5>Total</h5>
							<h4>Requests</h4>
						</div>
						<div class="stats-right">
							<label> <?=$total_request;?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>

					<div class="col-md-2 widget states-last">
						<div class="stats-left">
							<h5>Total</h5>
							<h4>Issues</h4>
						</div>
						<div class="stats-right">
							<label> <?=$total_issue;?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>

					<div class="clearfix"> </div>	
				</div>

				<div class="grid_3 grid_5 widget-shadow">
					<h3 class="hdg">Tasks</h3>
					<div class="col-md-12">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Project</th>
									<th>Task</th>
									<th>Request</th>
									<th>Issue</th>
									<th>Shortcut</th>
								</tr>
							</thead>
							<tbody>
								<?
								$get_project = "SELECT * FROM TR_PROJECT";
								$get_project = $db->select($get_project);

								foreach ($get_project as $key => $value) {
									$project_id = $value['id'];
									$project_name = $value['name'];	
									$project_pic = $value['pic_email'];		

									$task = "SELECT COUNT(*) as task FROM TR_TASK 
									WHERE project='$project_id' 
									AND stat <> 5";
									$task = $db->select($task);
									$task = $task[0]['task'];

									$req = "SELECT COUNT(*) as req FROM TR_TASK 
									WHERE type = 'REQUEST' 
									AND project='$project_id' 
									AND stat <> 5";
									$req = $db->select($req);
									$req = $req[0]['req'];

									$issue = "SELECT COUNT(*) as issue FROM TR_TASK 
									WHERE type = 'ISSUE' 
									AND project='$project_id' 
									AND stat <> 5";
									$issue = $db->select($issue);
									$issue = $issue[0]['issue'];

									?>

									<tr>
										<td>
											<span><?=$project_name;?></span>
											<br/>
											<code>
												<font style="font-size: 10px;"><?=$project_id;?></font>
											</code>
										</td>
										<td><span class="badge badge-primary"><?=$task;?></span></td>
										<td><span class="badge badge-info"><?=$req;?></span></td>
										<td><span class="badge badge-danger"><?=$issue;?></span></td>
										<td align="center">
											<a href="tasks_list.php"><span class="label label-default">Task</span></a>
											<a href="projects_list.php"><span class="label label-default">Project</span></a>
										</td>
									</tr>
									<?
								}
								?>
								
							</tbody>
						</table>                    
					</div>
				   <div class="clearfix"> </div>
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