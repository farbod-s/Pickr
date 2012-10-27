<header id="header" class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="#"><img src="<?php echo  base_url()?>/resources/images/pickr_logo.png" alt="pickr"
				style="width: 100px; height: 40px;">
			</a>
			<div class="nav-collapse collapse" style="height: 0px; ">
				<?php echo $nav?>
				<!--
				<p class="navbar-text pull-right">
					Logged in as <a href="#" class="navbar-link">Admin</a>
				</p>
			-->
				<form class="navbar-search pull-right" action="" _lpchecked="1">
					<input type="text" class="search-query span3" placeholder="Search" />
				</form>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</header>