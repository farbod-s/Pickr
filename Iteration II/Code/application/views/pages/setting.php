<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/www/codeigniter/assets/css/jquery.fileupload-ui.css"/>
<div class="container">
	<!-- Top Message -->
    <div class="alert alert-error" style="margin: 1%;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong style="margin-right: 1%;">You can change your profile information at any time ...</strong>
    </div>
    <!-- END Top Message -->

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



	
	  <form class="form-horizontal" id="update-profile-form" style="margin: 1%;" method="post" action="update_setting">
	  <legend><strong>Profile Information</strong></legend>
	  <div class="control-group">
	    <label class="control-label" for="firstName"><strong>First Name</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="name" placeholder="First Name" spellcheck="false" value="<?php echo $firstname; ?>" />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="lastName"><strong>Last Name</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="lastName" placeholder="Last Name" spellcheck="false" value="<?php echo $lastname; ?>" />
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
			  <input type="radio" name="gender" id="male" value="male" />
			  Male
			</label>
			<label class="radio inline">
			  <input type="radio" name="gender" id="female" value="female" />
			  Female
			</label>
			<label class="radio inline">
			  <input type="radio" name="gender" id="unspecified" value="unspecified" checked />
			  Unspecified
			</label>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label"><strong>Image</strong></label>
	    <div class="controls">
	      <div class="media">
			  <a class="pull-left" href="#">
			    <img class="media-object" id="profile-image" style="margin-right: 5px;" src="<?php if($pic_address != '') echo $pic_address; else echo base_url(IMAGES.'220x200.gif'); ?>">
			  </a>
			  <div class="media-body">
			    <!-- The fileinput-button span is used to style the file input field as button -->
	            <span class="btn btn-success fileinput-button">
	                <span><i class="icon-plus icon-white"></i> Add Image</span>
					<!-- Replace name of this input by userfile-->
	                <input type="file" name="userfile" multiple>
	            </span>
			  </div>
		  </div>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="description"><strong>Description</strong></label>
	    <div class="controls">
	      <div class="media">
	        <textarea class="pull-left media-object" id="description" rows="3" cols="40" style="resize: none; margin-right: 5px;" maxlength="50" placeholder="Introduce Yourself to Others" onfocus="ShowDescriptionMessage()" onBlur="HideDescriptionMessage()" spellcheck="false" value="<?php echo $description; ?>"></textarea>
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
	    </div>
	  </div>
	</form>
	<!-- END Profile Setting -->

	<!-- Acount Setting -->
	<?php $attributes = array('id' => 'change-pass-form', 'class' => 'form-horizontal', 'style' => 'margin: 1%;');
	echo form_open('index.php/user/changePassword', $attributes); ?>
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
	      <button type="submit" class="btn btn-primary btn-large"><strong>Change Password</strong></button>
	    </div>
	  </div>
	<?php echo form_close(); ?>
	<!-- END Account Setting -->
</div>