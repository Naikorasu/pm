<?php
require("./lib/library.php");

$get_users = "SELECT * FROM AUTH_USER";
$get_users = $db->select($get_users);

$get_projects = "SELECT * FROM TR_PROJECT";
$get_projects = $db->select($get_projects);

$get_type = "SELECT * FROM RF_TASK_TYPE";
$get_type = $db->select($get_type);

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
				
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>New Task :</h4>
						</div>
						<div class="form-body">
							<form action="tasks_add_process.php" method="post" enctype="multipart/form-data"> 

								<div class="form-group"> 
									<label for="task_title">Task Title</label> 
									<input type="text" class="form-control" id="task_title" name="task_title" placeholder="Title"> 
								</div>

								<div class="form-group"> 
									<label for="task_project">Project Related</label>
									<select class="form-control" id="task_project" name="task_project" placeholder="PIC">
										<?
										foreach ($get_projects as $key => $value) {
											?>
											<option value="<?=$value['id'];?>"><?=$value['name'];?></option>
											<?
										}
										?>
									</select>
								</div>

								<link rel="stylesheet" href="./css/bootstrap-datetimepicker.css" />
								<script type="text/javascript" src="./js/bootstrap-datetimepicker.js"></script>

								<div class="form-group">
									<label for="task_deadline">Task Deadline</label>

									<div class="input-group input-icon right" id="">
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input id="task_deadline" name="task_deadline" class="form-control1 date" type="text" placeholder="Deadline">
									</div>
									
								</div>
								<script type="text/javascript">
								    $("#task_deadline").datetimepicker({
								    	minView: 2,
								    	format: "dd/MM/yyyy",
								        autoclose: true,
								        todayBtn: true,
								    });
								</script> 

								<div class="form-group"> 
									<label for="task_type">Task Type</label>
									<select class="form-control" id="task_type" name="task_type" onchange="get_sub_type(this.value)">
										<option value="">- PICK TYPE -</option>
										<?
										foreach ($get_type as $key => $value) {
											?>
											<option value="<?=$value['code'];?>"><?=$value['name'];?></option>
											<?
										}
										?>
									</select>
								</div>

								<script>
									function get_sub_type(param) {
										var type = param;
										var request = $.ajax({
										  url: "type_list.php",
										  type: "POST",
										  data: {t : type},
										  dataType: "html"
										});

										request.done(function(msg) {
										  $("#task_type_group").html( msg );
										});

										request.fail(function(jqXHR, textStatus) {
										  alert( "Request failed: " + textStatus );
										});
									}
								</script>

								<div class="form-group" id="task_type_group"> 
									<label for="task_sub_type">Task Sub Type</label>
										<select class="form-control" id="task_sub_type" name="task_sub_type">
										</select>
								</div>

								<div class="form-group"> 
									<label for="task_level">Task Severity / Dificulty</label>
										<select class="form-control" id="task_level" name="task_level">
											<?
											for($x=0;$x<10;$x++) {
												?>
												<option value="<?=$x;?>"><?=$x;?></option>
												<?
											}
											?>
										</select>
								</div>


								<div class="form-group"> 
									<label for="task_dev">Developer</label>
									<select class="form-control" id="task_dev" name="task_dev" placeholder="Developer">
										<?
										foreach ($get_users as $key => $value) {
											?>
											<option value="<?=$value['email'];?>"><?=$value['email'];?> - <?=$value['name'];?></option>
											<?
										}
										?>
									</select>
								</div>

								<div class="form-group"> 
									<label for="task_qa">QA</label>
									<select class="form-control" id="task_qa" name="task_qa" placeholder="QA">
										<?
										foreach ($get_users as $key => $value) {
											?>
											<option value="<?=$value['email'];?>"><?=$value['email'];?> - <?=$value['name'];?></option>
											<?
										}
										?>
									</select>
								</div>

								<div class="form-group">
									<label for="task_screen_shot">Task Screenshot</label> 
									<i class="fa fa-paperclip"></i>
										<input type="file" id="task_screen_shot" name="task_screen_shot" style="width:100%;">
									<p class="help-block"><font style="color:#ff0000;">Max. 32MB</font></p>
								</div>

								<div class="form-group"> 
									<label for="task_desc">Task Description</label> 
									<textarea class="form-control" id="task_desc" name="task_desc" placeholder="Description"></textarea>
								</div>


								<div class="form-group"> 
									<label for="task_hastag">Task #Hashtag separated by comma(,)</label> 
									<textarea class="form-control" id="task_hastag" name="task_hastag" placeholder="Hashtag"></textarea>
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