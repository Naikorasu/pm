<?php
$email = $_SESSION['0c83f57c786a0b4a39efab23731c7ebc'];
$name = $_SESSION['b068931cc450442b63f5b3d276ea4297'];

//$fn->dump($_SESSION);
?>
<div class="profile_details">		
	<ul>
		<li class="dropdown profile_details_drop">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<div class="profile_img">	
					<span class="prfil-img"><img src="images/user.png" alt=""> </span> 
					<div class="user-name">
						<p><?=strtoupper($name);?></p>
						<span><?=$email;?></span>
					</div>
					<i class="fa fa-angle-down lnr"></i>
					<i class="fa fa-angle-up lnr"></i>
					<div class="clearfix"></div>	
				</div>	
			</a>
			<ul class="dropdown-menu drp-mnu">
				<li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li> 
				<li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li> 
				<li> <a href="login.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
			</ul>
		</li>
	</ul>
</div>