<?php
require("./lib/library.php");

$filter_progress = isset($_REQUEST['filter_progress']) ? $_REQUEST['filter_progress'] : 1;

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

$condition =  array('task_id'=>$id);
$progress = "SELECT * FROM TR_TASK_PROGRESS WHERE task_id = :task_id";
$progress = $db->select($progress,$condition);

if(count($progress) == 0) {
	header("location:tasks_list.php");
}


$array_progress = array();
foreach ($progress as $key => $value) {
	$stat = $value['progress_stat'];
	$path = $value['img_path'];
	$desc = $value['description'];
	$array_progress[$stat][$key]['img'] = $path;
	$array_progress[$stat][$key]['desc'] = $desc;
}

$array_filter = array(
	0=>"PENDING",
  	1=>"IN PROGRESS",
	2=>"DEVELOPMENT DONE",
	3=>"TESTED",
	4=>"IMPLEMENTED",
	5=>"DONE",
	6=>"OVERDUE",
	9=>"CANCEL",
);

foreach ($array_filter as $key => $value) {
	
	$var = $value;
	
	if($filter_progress == $key) {
		$$var = "selected";
	}
	else {
		$$var = "";
	}
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
					<li><a href="tasks_detail.php?id=<?=$id;?>">Detail</a></li>
					<li class="active">Progress Screenshot</li>
				</ol>

				<h3 class="title1"><?=strtoupper($title);?></h3>
				<h5><?=$id;?></h5>

				<div class="form-three widget-shadow">
					<form class="form-horizontal" id="form_filter" method="post" action="tasks_progress_screenshot.php" enctype="multipart/form-data">

						<div class="form-group">
							<label for="task_progress" class="col-sm-2 control-label">Progress</label>
							<div class="col-sm-8">
								<select name="filter_progress" onchange="javascript:go_filter();">
									<?
									foreach ($array_filter as $key => $value) {

										$var = $value;

										if($filter_progress == $key) {
											$$var = "selected";
										}
										else {
											$$var = "";
										}
										?>
										<option <?=$$var;?> value="<?=$key;?>"><?=$var;?></option>
										<?
									}
									?>
								</select>
								<input type="hidden" name="id" value="<?=$id;?>">
								<script>
									function go_filter(){
										document.getElementById('form_filter').submit();
									}
								</script>
							</div>
						</div>

					</form>
				</div>

				<?
				?>

				<div class="row">
					<div class="col-md-12 widget-shadow">
						<h4 class="title3"><?=$array_filter[$filter_progress];?></h4>

						<?
						if(isset($array_progress[$filter_progress]))
						{
							foreach ($array_progress[$filter_progress] as $key => $value) {
								$img = $value['img'];
								$desc = $value['desc'];
								?>
								<div class="col-md-4" align="center">
									<img src="<?=$img;?>" width="350px">
									<span><?=$desc;?></span>
								</div>
								<?
							}
						}
						else {
							?>
							<div class="col-md-4" align="center">
								<br/>
								<span>IMAGE NOT UPLOADED YET</span>
							</div>
							<?
						}
						?>
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