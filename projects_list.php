<?php
require("./lib/library.php");
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
					<h3 class="title1">Project List</h3>
					<span><a href="projects_add.php"><i class="fa fa-plus nav_icon"></i>Add Project</a></span>
					<div class="panel-body widget-shadow">
						<table class="table table-bordered">
							<thead>
								<tr>
								  <th>#</th>
								  <th>Project Name</th>
								  <th>PIC</th>
								  <th>Request</th>
								  <th>Issue</th>
								  <th>Action</th>
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

									$req = "SELECT COUNT(*) as req FROM TR_TASK 
									WHERE type = 'REQUEST' 
									AND project='$project_id' 
									AND stat <> 5";
									$req = $db->select($req);
									$req = $req[0]['req'];

									$issue = "SELECT COUNT(*) as issue 
									FROM TR_TASK WHERE type = 'ISSUE' 
									AND project='$project_id' AND stat <> 5";
									$issue = $db->select($issue);
									$issue = $issue[0]['issue'];

									?>
									<tr>
									  <th scope="row"><?=$key+1;?></th>
									  <td>
								  		<span><?=$project_name;?></span>
										<br/>
										<code>
											<font style="font-size: 10px;"><?=$project_id;?></font>
										</code>
									  </td>
									  <td><?=$project_pic;?></td>
									  <td><span class="badge badge-info"><?=$req;?></span></td>
									  <td><span class="badge badge-danger"><?=$issue;?></span></td>
									  <td>
									  	<a href="tasks_list.php?p=<?=$project_id;?>">Task</a>
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