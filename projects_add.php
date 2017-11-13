<?php
require("./lib/library.php");

$get_users = "SELECT * FROM AUTH_USER";
$get_users = $db->select($get_users);

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
					<li><a href="projects_list.php">Project List</a></li>
					<li class="active">Add</li>
				</ol>

				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>New Project :</h4>
						</div>
						<div class="form-body">
							<form action="projects_add_process.php" method="post"> 
								<div class="form-group"> 
									<label for="project_name">Project Name</label> 
									<input type="text" class="form-control" id="project_name" name="project_name" placeholder="Name"> 
								</div>
								<div class="form-group"> 
									<label for="project_pic">Project Person In Charge</label>
									<select class="form-control" id="project_pic" name="project_pic" placeholder="PIC">
										<?
										foreach ($get_users as $key => $value) {
											?>
											<option value="<?=$value['email'];?>"><?=$value['email'];?> - <?=$value['name'];?></option>
											<?
										}
										?>
									</select>
								</div>
								<button type="submit" class="btn btn-default">Submit</button> 
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