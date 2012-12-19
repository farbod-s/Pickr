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

		<div class="profile-details">
			<div class="pull-left">
				<img src="<?php if($pic_address != '') echo $pic_address; else echo base_url(IMAGES.'220x200.gif'); ?>" class="img-circle pull-left pickr-pic" style="width: 150px; height: 150px;" />
			</div>
			<div class="pull-left">
				<div class="profile-name"><?php if($firstname != '') echo $firstname; else echo "Here's";?> 
				<?php if($lastname != '') echo $lastname; else echo "name"; ?></div>
				<div class="profile-description"><?php if($description != '') echo $description; else echo "Here's Description";?></div>
			</div>
			<!--
			<div class="pull-right" style="width: 20%;">
				<div class="profile-picks">
					<div class="picks-title pull-left">Picks</div>
					<div class="picks-amount pull-right">23</div>
				</div>
				<div class="profile-likes">
					<div class="likes-title pull-left">Likes</div>
					<div class="likes-amount pull-right">76</div>
				</div>
				<div class="profile-follows">
					<div class="follows-title pull-left">Follows</div>
					<div class="follows-amount pull-right">104</div>
				</div>
				<div class="profile-followers">
					<div class="followers-title pull-left">Followers</div>
					<div class="followers-amount pull-right">98</div>
				</div>
			</div> -->
		</div>

	<div class="boards">
		<?php
      	for($i = 1; $i < 6; $i++) { ?>
		<div class="pin pinBoard" id="board1">
			<div class="board">
				<div class="holder">
					<span class="cover">
						<img src="<?php echo base_url(IMAGES.'upload_picture.png');?>" style="width: 100%;">
					</span>
					<span class="thumbs">
					<img src="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
					<img src="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
					<img src="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
					<img src="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
					</span>
				</div>
				<div class="buttonContainer">
					<button class="btn" type="submit" style="width: 100%; height: 100%; border-radius: 0 0 6px 6px;">
						<strong>Edit Album</strong>
					</button>
				</div>
			</div>
		</div>
		<?php } ?>
				<div class="pin pinBoard createBoard emptyBoard">
			<div class="holder">
				<span class="cover empty"></span>
				<span class="thumbs">
					<span class="empty"></span>
					<span class="empty"></span>
					<span class="empty"></span>
					<span class="empty"></span>
				</span>
			</div>
			<div class="createBoardSubmitNoHover">New Album</div>
			<div class="buttonContainer">
				<button class="btn" type="submit" style="width: 100%; height: 100%; border-radius: 0 0 6px 6px;">
					<strong>Create Album</strong>
				</button>
			</div>
		</div>
	</div>


<!--
    	<?php if($albums_detail && !empty($albums_detail)) { ?>
		<div>
			<ul class="thumbnails">
			<?php
			foreach($albums_detail as $name => $first_pic) { ?>
				<li class="span4">
					<div class="thumbnail">
						<img src="<?php echo $first_pic; ?>" alt="">
						<h4 align="center"><?php echo $name; ?></h4>
						<p align="center">
							<button class="btn btn-primary" type="button">Edit Album</button>
						</p>
					</div>
				</li> 						
			<?php } ?>
			</ul>
		</div>
		<?php } ?>
	-->
	</div>
</div>