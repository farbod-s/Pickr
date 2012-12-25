<header id="header" class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php echo base_url();?>" style="height: 40px;">
				<img class="visible-desktop" style="margin-top: -10px; width: 45px; height: 100px;" src="<?php echo  base_url(IMAGES.'brand.png');?>" alt="pickr" />
				<img class="hidden-desktop" style="display: none; width: 100px; height: 40px;" src="<?php echo  base_url(IMAGES.'pickr_logo.png');?>" alt="pickr" />
			</a>
			<div class="nav-collapse collapse" style="height: 0px; ">
				<?php echo $nav?>

				<?php
					if (!$this->tank_auth->is_logged_in()) { ?>
						<!-- The Login drop down menu -->
				        <ul class="nav pull-left">
			        	  <li class="divider-vertical"></li>
				          <li class="dropdown header-link">
				            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
				            	<i class="icon-user icon-white icon-group"></i> <strong>Sign In</strong> <strong class="caret"></strong>
				            </a>
				            <div class="dropdown-menu" style="padding: 15px;">
				              <!-- Login form -->
				              <div id="formContainer">
				              	<?php
					              $attributes = array('id' => 'login-form');
			        			  echo form_open(base_url('auth/login'), $attributes);
			        			  ?>
							  	  <input type="text" id="name" name="name" placeholder="Username / Email" spellcheck="false" />
	                	  		  <input type="password" id="pass" name="pass" placeholder="Password" />
			              	 	  <input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="remember_me" value="1" />
			              	 	  <label class="string optional" for="user_remember_me"> Remember me</label>
			              	 	  <input type="submit" class="btn btn-primary" id="login-btn" style="clear: left; width: 100%; height: 32px; font-weight: bold;" value="Sign In" />
			              	 	  <li class="divider" style="width: 100%;"></li>
			              	 	  <li><a href="#" id="flipToRecover" class="flipLink" style="background-color: #fff; color: #000; padding: 0;"><strong>Forgot password?</strong></a></li>
			              	 	  <?php echo form_close();
								   $attributes = array('id' => 'recovery-form');
			        				echo form_open(base_url('auth/recover'), $attributes);
			        				?>
								  	<input type="email" name="recoverEmail" id="recoverEmail" placeholder="Email Address" spellcheck="false" required />
								  	<input type="submit" name="submit" class="btn btn-primary" id="recover-btn" style="clear: left; width: 100%; height: 32px; font-weight: bold;" value="Recover" />
								  	<li class="divider" style="width: 100%;"></li>
								  	<li><a href="#" id="flipToLogin" class="flipLink" style="background-color: #fff; color: #000; padding: 0;"><strong>Back to Login</strong></a></li>
								  <?php echo form_close();
								  ?>
							  </div>
				            </div>
				          </li>
				        </ul>
		    		<?php }
		    		else { ?>
		    			<!-- The User Control drop down menu -->
			        	<ul class="nav pull-left">
			        	  <li class="divider-vertical"></li>
			        	  <li class="header-link">
				          	<a href="#upload-picture-form" data-toggle="modal"><i class="icon-upload icon-white icon-group"></i> Upload</a>
				          </li>
			        	  <li class="divider-vertical"></li>
				          <li class="dropdown header-link">
				            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
								<i class="icon-user icon-white icon-group"></i>
				            	<strong>
				            		<?php
				            	$username = $this->tank_auth->get_username();
				            	$name = $this->tank_auth->get_complete_name();
				            	if($name && $name != '' && $name != ' ') {
				            		echo $name;
				            	}
				            	else {
				            		echo $username;
				            	}
				            	?>
				            	</strong> <strong class="caret"></strong>
				            </a>
				            	<!-- User Control -->
				            	<ul class="dropdown-menu">
					            	<li><a href="<?php echo base_url().'user/'.$username?>"><i class="icon-inbox"></i> Dashboard</a></li>
								    <li><a href="<?php echo base_url('setting');?>"><i class="icon-wrench"></i> Setting</a></li>
								    <!-- <li><a href="#"><i class="icon-upload"></i> Upload</a></li> -->
								    <li class="divider"></li>
								    <li><a href="<?php echo base_url('auth/logout')?>"><i class="icon-off"></i> Sign Out</a></li>
								</ul>
				          </li>
				        </ul>
		    		<?php } ?>

				<form class="navbar-search pull-right" action="" _lpchecked="1">
					<input type="text" class="search-query span3" spellcheck="false" placeholder="Search" />
				</form>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</header>