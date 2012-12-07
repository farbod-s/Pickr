<?php
  $is_logged_in = $this->tank_auth->is_logged_in(); 
?>
<div class="container">
	<div id="holder">
		<?php
			$firstname = "";
			$lastname = "";
			$description = "";
			$pic_address = "";

			if($profile_info) {
				$firstname = $profile_info[0]['firstname'];
				$lastname = $profile_info[0]['lastname'];
				$description = $profile_info[0]['description'];
				$pic_address = $profile_info[0]['pic_address'];
			}
		?>

		<div class="alert alert-errorr" style="margin: 1%;">
			<div class="row">
				<div class="span3">
					<img src="<?php if($pic_address != '') echo $pic_address; else echo base_url(IMAGES.'220x200.gif'); ?>" class="img-rounded">
				</div>
				<div class="span2">
					<p class="lead"><?php if($firstname != '') echo $firstname; else echo "Here's";?> 
					<?php if($lastname != '') echo $lastname; else echo "name"; ?></p>
					<p><legend><?php if($description != '') echo $description; else echo "Here's Description";?></legend></p>
				</div>
				<div class="span1">
		
				</div>
			</div>
		</div>
    

		<div>
			<ul class="thumbnails">
				<?php
					if(empty($albums)){
						echo '
							<li class="span4">
								<div class="thumbnail">
									<img src="http://placehold.it/300x200" alt="">
									<h4 align="center">Album Name</h4>
									<p align="center">
										<button class="btn btn-primary" type="button">Edit Album </button>
									</p>
								</div>
							</li>
							<li class="span4">
								<div class="thumbnail">
									<img src="http://placehold.it/300x200" alt="">
									<h4 align="center">Album Name</h4>
									<p align="center">
										<button class="btn btn-primary" type="button">Edit Album </button>
									</p>
								</div>
							</li>
							<li class="span4">
								<div class="thumbnail">
									<img src="http://placehold.it/300x200" alt="">
									<h4 align="center">Album Name</h4>
									<p align="center">
										<button class="btn btn-primary" type="button">Edit Album </button>
									</p>
								</div>
							</li>
							<li class="span4">
								<div class="thumbnail">
									<img src="http://placehold.it/300x200" alt="">
									<h4 align="center">Album Name</h4>
									<p align="center">
										<button class="btn btn-primary" type="button">Edit Album </button>
									</p>
								</div>
							</li>
							<li class="span4">
								<div class="thumbnail">
									<img src="http://placehold.it/300x200" alt="">
									<h4 align="center">Album Name</h4>
									<p align="center">
										<button class="btn btn-primary" type="button">Edit Album </button>
									</p>
								</div>
							</li>
							<li class="span4">
								<div class="thumbnail">
									<img src="http://placehold.it/300x200" alt="">
									<h4 align="center">Album Name</h4>
									<p align="center">
										<button class="btn btn-primary" type="button">Edit Album </button>
									</p>
								</div>
							</li>
						';
					}
					else {						
						foreach($albums as $album){
							echo '
								<li class="span4">
									<div class="thumbnail">
										<img src="http://placehold.it/300x200" alt="">
										<h4 align="center">$album</h4>
										<p align="center">
											<button class="btn btn-primary" type="button">Edit Album </button>
										</p>
									</div>
								</li> 
							';							
						}
					}
				?>
			</ul>	
		</div>
	</div>
</div>

<button id="ScrollToTop" class="Button WhiteButton Indicator" type="button" style="display: none;">
  Scroll to Top
</button>



































