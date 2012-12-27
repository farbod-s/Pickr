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
			<img src="<?php if($pic_address != '') echo $pic_address; else echo base_url(IMAGES.'220x200.gif'); ?>" class="img-circle pull-left pickr-pic" style="width: 150px; height: 150px;" />
		</div>
		<div class="pull-left">
			<div class="profile-name"><?php if($firstname != '') echo $firstname; else echo "Here's";?> 
			<?php if($lastname != '') echo $lastname; else echo "name"; ?><?php if($ME) echo " (You)"?></div>
			<div class="profile-description visible-desktop"><?php if($description != '') echo $description; else echo "Here's Description";?></div>
			<?php if(!$ME && $album_count != 0) {?>
				<button class="btn btn-large btn-danger follow-all-btn">Follow All</button>
			<?php }?>
		</div>
		<div class="pull-right hidden-phone">
			<div class="user-records">
				<p style="padding: 5px;">Followers<span class="pull-right">---</span></p>
				<p style="padding: 5px;">Following<span class="pull-right">---</span></p>
				<p style="padding: 5px;">Likes<span class="pull-right">---</span></p>
				<p style="padding: 5px;">Picks<span class="pull-right">---</span></p>
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
			foreach($albums_detail as $name => $first_pic) { ?>
		<div class="pin pinBoard" id="board1">
			<a href="<?php echo base_url('user/'.strtolower($username).'/'.preg_replace('![^a-z0-9_]+!i', '-', strtolower($name)))?>"><div class="serif"><?php echo htmlspecialchars($name); ?></div></a>
			<div class="board">
				<div class="holder">
					<span class="cover">
						<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $first_pic[0]; ?>" style="width: 100%; min-height: 150px;">
					</span>
					<span class="thumbs">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $first_pic[1]; ?>" alt="Photo of a pin">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $first_pic[2]; ?>" alt="Photo of a pin">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $first_pic[3]; ?>" alt="Photo of a pin">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $first_pic[4]; ?>" alt="Photo of a pin">
					</span>
				</div>
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
					<?php } else {?>
						<!-- TODO -->
						<button class="btn" type="submit" style="width: 100%; height: 100%; border-radius: 0 0 6px 6px;">
							<strong>Follow</strong>
						</button>
					<?php }?>
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
		          <div class="error-message" style="margin-top: 10px;">Correct album name</div>
		        </div>
	          </div>
	          <?php echo form_close();?>
	        </div>
	        <!-- END create Form -->
		<?php }?>
	</div>
</div>