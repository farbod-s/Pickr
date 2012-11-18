<div class="container">
	<!-- Top Message -->
    <div class="alert alert-error" style="margin-top: 1%;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong style="margin-right: 1%;">You can change your profile information at any time ...</strong>
    </div>
    <!-- END Top Message -->

    <!-- Profile Setting -->
	<?php $attributes = array('id' => 'update-profile-form', 'class' => 'form-horizontal');
	        				echo form_open('index.php/user/updateProfile', $attributes); ?>
	  <legend><strong>Profile Information</strong></legend>
	  <div class="control-group">
	    <label class="control-label" for="firstName"><strong>First Name</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="name" placeholder="First Name" spellcheck="false" />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="lastName"><strong>Last Name</strong></label>
	    <div class="controls">
	      <input class="input-large" type="text" id="lastName" placeholder="Last Name" spellcheck="false" />
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="email"><strong>Email</strong></label>
	    <div class="controls">
	      <input class="input-large uneditable-input" type="email" id="email" placeholder="unknown.user@domain.com" spellcheck="false" disabled />
	      <button class="btn"><i class="icon-envelope"></i> Email Setting</button>
	    </div>
	  </div>
	  <div class="control-group">
	  	<label class="control-label" for="lastName"><strong>Gender</strong></label>
	    <div class="controls">
	        <label class="radio inline">
			  <input type="radio" name="optionsRadios" id="optionsRadios1" value="male" />
			  Male
			</label>
			<label class="radio inline">
			  <input type="radio" name="optionsRadios" id="optionsRadios2" value="female" />
			  Female
			</label>
			<label class="radio inline">
			  <input type="radio" name="optionsRadios" id="optionsRadios3" value="unspecified" checked />
			  Unspecified
			</label>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="lastName"><strong>Image</strong></label>
	    <div class="controls">
	      <div class="media">
			  <a class="pull-left" href="#">
			    <img class="media-object" style="margin-right: 5px;" src="http://placehold.it/220x200">
			  </a>
			  <div class="media-body">
			    <button class="btn btn-success"><i class="icon-upload icon-white"></i> Upload Image</button>
			  </div>
		  </div>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="description"><strong>Description</strong></label>
	    <div class="controls">
	      <div class="media">
	        <textarea class="pull-left media-object" id="description" rows="3" cols="40" style="resize: none; margin-right: 5px;" maxlength="50" placeholder="Introduce Yourself to Others" onfocus="ShowDescriptionMessage()" onBlur="HideDescriptionMessage()" spellcheck="false"></textarea>
	        <div class="media-body">
	        	<span class="charsRemaining" style="display: none;"> 50 characters remaining</span>
	        </div>
	      </div>
		</div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	      <button type="submit" class="btn btn-primary btn-large"><strong>Save Profile</strong></button>
	    </div>
	  </div>
	<?php echo form_close(); ?>
	<!-- END Profile Setting -->

	<!-- Acount Setting -->
	<?php $attributes = array('id' => 'change-pass-form', 'class' => 'form-horizontal');
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