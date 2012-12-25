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
		<div class="pull-left">
			<img src="<?php if($pic_address != '') echo $pic_address; else echo base_url(IMAGES.'220x200.gif'); ?>" class="img-circle pull-left pickr-pic" style="width: 150px; height: 150px;" />
		</div>
		<div class="pull-left">
			<div class="profile-name"><?php if($firstname != '') echo $firstname; else echo "Here's";?> 
			<?php if($lastname != '') echo $lastname; else echo "name"; ?><?php if($ME) echo " (You)"?></div>
			<div class="profile-description"><?php if($description != '') echo $description; else echo "Here's Description";?></div>
		</div>
		<div class="pull-right">
			<?php if(!$ME && $album_count != 0) {?>
				<button class="btn btn-large btn-danger">Follow All</button>
			<?php }?>
		</div>
	</div>

	<!-- <hr class="soft" /> -->
	<div id="TitlePro">
        <h1>
            <span>Albums</span>
        </h1>
    </div>

	<div class="boards">
		<?php if($albums_detail && !empty($albums_detail)) {
			foreach($albums_detail as $name => $first_pic) { ?>
		<div class="pin pinBoard" id="board1">
			<a href="<?php echo base_url('user/'.strtolower($username).'/'.preg_replace('![^a-z0-9_]+!i', '-', strtolower($name)))?>"><div class="serif"><?php echo $name; ?></div></a>
			<div class="board">
				<div class="holder">
					<span class="cover">
						<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $first_pic; ?>" style="width: 100%; min-height: 150px;">
					</span>
					<span class="thumbs">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
					<img class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo base_url(IMAGES.'grey.gif');?>" alt="Photo of a pin">
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
					<!-- TODO -->
					<button class="btn" type="submit" style="width: 100%; height: 100%; border-radius: 0 0 6px 6px;">
						<strong>Create Album</strong>
					</button>
				</div>
			</div>
		<?php }?>
	</div>
</div>