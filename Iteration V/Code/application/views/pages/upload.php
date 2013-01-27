<!-- upload Form -->
<div class="modal-container upload-modal">
<div id="upload-picture-form" style="margin: 50px auto;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="uploadLabel" aria-hidden="true">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	  <h3 id="uploadLabel">Upload</h3>
	</div>
	<div class="modal-body">
	  <div class="control-group pull-right" style="width: 50%; margin-bottom: 0;">
	    <div class="btn-group">
	      <button style="width: 100%; height: 33px;" id="upload-current-album" class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	        <strong style="float: left;">Select Album</strong>
	        <span class="caret" style="float: right;"></span>
	      </button>
	      <ul id="upload-album_list" class="dropdown-menu" style="width: 100%; max-height: 145px; overflow-x: hidden; overflow-y: auto;">
	        <!-- dropdown menu links -->
	        <div class="albums">
	        <?php if($albums) {
	          foreach ($albums as $album) { ?>
	            <li style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><a style="cursor: pointer;" onClick="SetCurrentAlbum_upload(this.innerHTML)"><?php echo htmlspecialchars($album); ?></a></li>
	          <?php }
	        }?>
	        </div>
	        <li class="divider"></li>
	        <li>
	          <?php
	          $attributes = array('id' => 'upload-create-album-form', 'class' => 'form-horizontal');
	          echo form_open(base_url('home/create_album'), $attributes); ?>
	            <input type="text" id="upload_album_name" class="input-small pull-left" style="width: 64%; margin: 0 3% 3% 3%;" placeholder="Album Name" spellcheck="false" />
	            <button type="submit" class="btn pull-right" id="upload-create-album-btn" data-loading-text="..."><strong>Create</strong></button>
	          <?php echo form_close(); ?>
	        </li>
	      </ul>
	    </div>
	  </div>
	  <form method="post" action="" id="upload_file">
		  <div class="control-group pull-left" style="width: 50%; margin: 0;">
	  		<a href="#" style="width: 100%;">
		    	<img class="thumbnail" id="uploaded-pic" style="margin-right: 5px; width: 90%; max-height: 350px; min-height: 175px;" src="<?php echo base_url(IMAGES.'upload_picture.png'); ?>">
		  	</a>
		  	<input type="file" name="userfile" id="userfile" size="20" style="width: 90%; margin-top: 10px; margin-bottom: 0;" />
		  </div>
		  <div class="control-group pull-right" style="width: 50%; margin-bottom: 0;">
		    <textarea id="upload-album-description" rows="3" cols="40" style="resize: none; margin-top: 10%; width: 96.5%;" maxlength="50" placeholder="Description" spellcheck="false"></textarea>
		    <button type="submit" class="btn btn-large btn-primary disabled" data-loading-text="Uploading..." id="upload-btn" style="width:100%; margin-top:5%; font-weight: bold;" disabled="disabled">Upload</button>
		  </div>
	  </form>
	</div>
	<div class="modal-footer">
	  <div class="pull-left">
	    <div class="error-message">Wrong album name</div>
	  </div>
	  <div class="pull-right">
	  	<div><img id="loading" style="display:none" src="<?php echo base_url(IMAGES.'ajax-loader.gif'); ?>"></div>
	  	<div id="success-upload-msg" style="font-weight: bold; color: green; display: none;">Successfully uploaded</div>
	  </div>
	</div>
</div>
</div>
<!-- END upload Form -->