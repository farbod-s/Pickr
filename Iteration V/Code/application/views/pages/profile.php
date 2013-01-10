<div class="container">
	<?php
		$firstname = "";
		$lastname = "";
		$description = "";
		$pic_address = "";
		$album_count = count($albums_detail);

		if($profile_info) {
			$firstname = $profile_info->firstname;
			$lastname = $profile_info->lastname;
			$description = $profile_info->description;
			$pic_address = $profile_info->pic_address;
		}
	?>

	<div class="profile-details">
		<div class="pull-left visible-desktop">
			<img src="<?php if($pic_address != '') echo $pic_address; else echo base_url(IMAGES.'upload_picture.png'); ?>" class="img-circle pull-left pickr-pic" style="width: 150px; height: 150px;" />
		</div>
		<div class="pull-left">
			<div class="profile-name"><?php if($firstname != '') echo $firstname; else echo "Here's";?> 
			<?php if($lastname != '') echo $lastname; else echo "name"; ?><?php if($ME) echo " (You)"?></div>
			<div class="profile-description visible-desktop"><?php if($description != '') echo $description; else echo "Here's Description";?></div>
			<?php if(!$ME && $album_count != 0) {?>
				<?php
				if(!$person_followed) { ?>
					<button class="btn btn-large btn-danger follow-all-btn" type="submit" data-loading-text="Following All...">Follow All</button>
				<?php } else { ?>
					<button class="btn btn-large btn-danger unfollow-all-btn" type="submit" data-loading-text="Unfollowing All...">Unfollow All</button>
				<?php }	?>		
			<?php }?>
		</div>
		<div class="pull-right hidden-phone">
			<div class="user-records">
				<p style="padding: 5px;">Followers<span class="pull-right"><?php echo $follower_count;?></span></p>
				<p style="padding: 5px;">Following<span class="pull-right"><?php echo $following_count;?></span></p>
				<p style="padding: 5px;">Likes<span class="pull-right"><?php echo $like_count;?></span></p>
				<p style="padding: 5px;">Picks<span class="pull-right"><?php echo $pick_count;?></span></p>
			</div>
		</div>
	</div>

	<div id="TitlePro">
        <h1>
            <span>Albums</span>
        </h1>
    </div>

	<div class="boards">
		<?php if($albums_detail && !empty($albums_detail)) {
			foreach($albums_detail as $album_id => $details) { 
				$name = $details['name'];
				$first_pic = $details['pic'];
		?>
		<div class="pin pinBoard" id="album_<?php echo $album_id;?>">
			<div class="serif"><?php echo htmlspecialchars($name); ?></div>
			<div class="board">
				<a href="<?php echo base_url('user/'.strtolower($username).'/'.preg_replace('![^a-z0-9_]+!i', '-', strtolower($name)))?>">
				<div class="holder">
					<span class="cover">
						<img src="<?php echo $first_pic[0]; ?>" style="width: 100%; min-height: 150px;">
					</span>
					<span class="thumbs">
					<img src="<?php echo $first_pic[1]; ?>" alt="Photo of a pick">
					<img src="<?php echo $first_pic[2]; ?>" alt="Photo of a pick">
					<img src="<?php echo $first_pic[3]; ?>" alt="Photo of a pick">
					<img src="<?php echo $first_pic[4]; ?>" alt="Photo of a pick">
					</span>
				</div>
				</a>
				<div class="buttonContainer">
					<?php if($ME) {
						$attributes = array('class' => 'form-horizontal',
											'style' =>  'width: 100%; height: 100%;');
						 // clean URL
            			echo form_open(base_url('user/'.strtolower($username).'/'.preg_replace("![^a-z0-9_]+!i", "-", strtolower($name))), $attributes); ?>
							<button class="btn" type="submit" style="width: 100%; height: 100%; border-radius: 0 0 6px 6px;">
								<strong>Edit</strong>
							</button>
						<?php echo form_close(); ?>
					<?php } else {
						if (!in_array($album_id, $followed_albums)) { ?>
							<button class="btn follow-btn" type="submit" data-loading-text="Following..." style="width: 100%; height: 100%; border-radius: 0 0 6px 6px;">
								<strong>Follow</strong>
							</button>
						<?php } else { ?>
							<button class="btn unfollow-btn" type="submit" data-loading-text="Unfllowing..." style="width: 100%; height: 100%; border-radius: 0 0 6px 6px;">
								<strong>Unfollow</strong>
							</button>
						<?php }
					}?>
				</div>
			</div>
		</div>
		<?php } }?>

		<?php if($ME) {?>
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
					<a href="#new_album" style="width: 90.5%; height: 75%; line-height: 25px; border-radius: 0 0 6px 6px; border-radius: 0 0 6px 6px;" role="button" class="btn" data-toggle="modal"><strong>Create Album</strong></a>
				</div>
			</div>

			<!-- create Form -->
	        <div id="new_album" class="modal hide fade modal-small" tabindex="-1" role="dialog" aria-labelledby="newAlbumLabel" aria-hidden="true">
	          <?php $attributes = array('id' => 'new-album-form', 'class' => 'form-horizontal');
	          echo form_open(base_url('profile/new_album'), $attributes); ?>
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            <h3 id="newAlbumLabel">Create Album</h3>
	          </div>
	          <div class="modal-body">
	            <div class="control-group">
	                <div class="controls" style="margin-left: 75px; margin-top: 18px;">
	                  <input type="text" id="album_name" name="album_name" value="<?php echo set_value('album_name');?>" placeholder="Album Name" spellcheck="false" />
	                </div>
	            </div>
	          </div>
	          <div class="modal-footer"> 
	            <button type="submit" class="btn btn-large btn-primary" id="new-album-btn" data-loading-text="Creating Album...">Create New Album</button>
	          	<div class="pull-left">
		          <div class="error-message" style="margin-top: 10px;">Wrong album name</div>
		        </div>
	          </div>
	          <?php echo form_close();?>
	        </div>
	        <!-- END create Form -->
		<?php }?>
	</div>
</div>