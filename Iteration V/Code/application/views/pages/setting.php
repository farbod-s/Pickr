<div class="container">
    <!-- Profile Setting -->
    <?php
    	$country = "";
		$website = "";
		$firstname = "";
		$lastname = "";
		$gender = "";
		$description = "";
		$pic_address = "";

    	if($profile_info) {
			$country = $profile_info[0]['country'];
			$website = $profile_info[0]['website'];
			$firstname = $profile_info[0]['firstname'];
    		$lastname = $profile_info[0]['lastname'];
    		$gender = $profile_info[0]['gender'];
    		$description = $profile_info[0]['description'];
    		$pic_address = $profile_info[0]['pic_address'];
    	}
    ?>
	
	<?php $attributes = array('id' => 'update-profile-form', 'class' => 'form-horizontal', 'style' => 'margin: 1%;');
	echo form_open(base_url('setting/update_setting'), $attributes); ?>
	  <legend><strong>Profile Information</strong></legend>
	  <div class="control-group">
	    <label class="control-label" for="firstname"><strong>First Name</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="firstname" placeholder="First Name" spellcheck="false" value="<?php echo $firstname; ?>" />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="lastname"><strong>Last Name</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="lastname" placeholder="Last Name" spellcheck="false" value="<?php echo $lastname; ?>" />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="email"><strong>Email</strong></label>
	    <div class="controls">
	      <input class="input-large uneditable-input" type="email" id="email" placeholder="<?php echo $this->tank_auth->get_user_email(); ?>" spellcheck="false" disabled />
	      <button class="btn"><i class="icon-envelope"></i> Email Setting</button>
	    </div>
	  </div>
	  <div class="control-group">
	  	<label class="control-label"><strong>Gender</strong></label>
	    <div class="controls">
	        <label class="radio inline">
			  <input type="radio" name="gender" id="male" value="1" <?php if($gender == '1') echo 'checked';?> />
			  Male
			</label>
			<label class="radio inline">
			  <input type="radio" name="gender" id="female" value="0" <?php if($gender == '0') echo 'checked';?> />
			  Female
			</label>
			<label class="radio inline">
			  <input type="radio" name="gender" id="unspecified" value="2" <?php if($gender == '2') echo 'checked'; if($gender == '') echo 'checked';?> />
			  Unspecified
			</label>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label"><strong>Image</strong></label>
	    <div class="controls">
	      <div class="media">
			  <a class="pull-left" href="#">
			    <img class="media-object" id="profile-image" style="width: 220px; margin-right: 5px;" src="<?php if($pic_address != '') echo $pic_address; else echo base_url(IMAGES.'upload_picture.png'); ?>">
			  </a>
			  <div class="media-body">
			    <!-- The fileinput-button span is used to style the file input field as button -->
					<!-- Replace name of this input by userfile-->
	                <input type="file" name="profile_pic" id="profile_pic" />
			  </div>
		  </div>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="description"><strong>Description</strong></label>
	    <div class="controls">
	      <div class="media">
	        <textarea class="pull-left media-object" id="description" rows="3" cols="40" style="resize: none; margin-right: 5px;" maxlength="50" placeholder="Introduce Yourself to Others" onfocus="ShowDescriptionMessage()" onBlur="HideDescriptionMessage()" spellcheck="false"><?php if($description != '') echo $description; ?></textarea>
	        <div class="media-body">
	        	<span class="charsRemaining" style="display: none;"> 50 characters remaining</span>
	        </div>
	      </div>
		</div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="country"><strong>Location</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="country" placeholder="Location" spellcheck="false" value="<?php echo $country; ?>" />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="website"><strong>Website</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="website" placeholder="Website" spellcheck="false" value="<?php echo $website; ?>" />
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	      <button type="submit" id="save-profile-btn" class="btn btn-primary btn-large"><strong>Save Profile</strong></button>
	      <span class="error" style="margin-left: 105px; font-weight: bold; color: #B94A48; opacity: 0;">Changes not found<span>
	    </div>
	  </div>
	<?php echo form_close();?>
	<!-- END Profile Setting -->

	<!-- Acount Setting -->
	<?php $attributes = array('id' => 'change-pass-form', 'class' => 'form-horizontal', 'style' => 'margin: 1%;');
	echo form_open(base_url('auth/changePassword'), $attributes); ?>
	  <legend><strong>Account Setting</strong></legend>
	  <div class="control-group">
	    <label class="control-label" for="old_pass"><strong>Old Password</strong></label>
	    <div class="controls">
	      <input class="input-large" type="password" id="old_pass" minlength="6" placeholder="Old Password" required />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="new_pass"><strong>New Password</strong></label>
	    <div class="controls">
	      <input class="input-large" type="password" id="new_pass" minlength="6" placeholder="New Password" required />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="confirm_new_pass"><strong>Confirm Password</strong></label>
	    <div class="controls">
	      <input class="input-large" type="password" id="confirm_new_pass" minlength="6" equalto="#new_pass" placeholder="Confirm New Password" required />
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	      <button type="submit" id="change-pass-btn" class="btn btn-primary btn-large"><strong>Change Password</strong></button>
	    </div>
	  </div>
	<?php echo form_close(); ?>
	<!-- END Account Setting -->
</div>