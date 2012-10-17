<ul class="nav">
	<li class="active"><a class="<?php echo isActive($pageName,"home")?>" href="<?php echo  base_url()?>">Home</a></li>
	<li><a class="<?php echo isActive($pageName,"about")?>" href="<?php echo  base_url()?>">About</a></li>
	<li><a class="<?php echo isActive($pageName,"contact")?>" href="<?php echo  base_url()?>">Contact</a></li>
	
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="#">Action</a></li>
		<li><a href="#">Another action</a></li>
		<li><a href="#">Something else here</a></li>
		<li class="divider"></li>
		<li class="nav-header">Nav header</li>
		<li><a href="#">Separated link</a></li>
		<li><a href="#">One more separated link</a></li>
	</ul>
	</li>
	
</ul>