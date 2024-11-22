
<style>
	.collapse a{
		text-indent:10px;
	}
</style>
<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<?php if($_SESSION['login_type'] == 1): ?>

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a  class="nav-item nav-manage_park nav-collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class='icon-field'><i class="fa fa-map"></i></span> Parking <span class="float-right"><i class="fa fa-angle-down"></i></span></a>
				<div class="collapse" id="collapseExample">
					<a href="index.php?page=manage_park" class="nav-item nav-manage_park"> Check-In</a>	
					<a href="index.php?page=park_list" class="nav-item nav-park_list"> List</a>	
				</div>
				<a href="index.php?page=category" class="nav-item nav-category"><span class='icon-field'><i class="fa fa-list"></i></span> Category</a>	
				<a href="index.php?page=location" class="nav-item nav-location"><span class='icon-field'><i class="fa fa-map"></i></span> Parking Area</a>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				
			<?php else: ?>
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=manage_park" class="nav-item nav-manage_park"> Check-In</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
