<div class="container">
	<?php
		$description = "";
		$album_name = "";

		if($album_info) {
			$album_name = $album_info[0]['name'];
			$description = $album_info[0]['description'];
		}
	?>

	<div class="profile-details">
    <div class="pull-left">
      <p class="album-name"><?php echo htmlspecialchars($album_name); ?></p>
      <p class="album-description"><?php echo $description;?></p>
      <?php if(!$ME) {?>
        <button class="btn btn-large btn-danger follow-album-btn">Follow</button>
      <?php } else {?>
        <a href="#rename_album" role="button" class="btn btn-small" data-toggle="modal"><i class="icon-edit"></i> Rename</a>
        <a href="#delete_album" role="button" class="btn btn-small" data-toggle="modal"><i class="icon-trash"></i></a>
        <?php }?>
    </div>
    <div class="pull-right hidden-phone">
      <div class="album-records">
        <p style="padding: 5px;">Followers<span class="pull-right"><?php echo $follows;?></span></p>
        <p style="padding: 5px;">Picks<span class="pull-right"><?php echo $picks?></span></p>
        <p style="padding: 5px;">Owner<span class="pull-right"><a href="<?php echo base_url('user'.'/'.$username);?>"><?php if($complete_name && $complete_name != '' && $complete_name != ' ') echo $complete_name; else echo $username;?></a></span></p>
      </div>
    </div>
	</div>

	<div id="TitlePro">
    <h1>
        <span>Picks</span>
    </h1>
  </div>
  <div style="border-top: 1px solid #BFBFBF;"></div> <!-- for it's line! -->
</div>

  <!-- Load Pictures -->
  <ul id="tiles" style="margin: 80px 0 0 0;">
    <!-- Load Here -->
  </ul>
  <!-- END Load Pictures -->

  <div id="loader">
    <div id="loaderCircle"></div>
  </div>

    <?php if($ME) {?>
      <!-- rename Form -->
      <div class="modal-container rename-album-modal">
      <div id="rename_album" style="margin: 50px auto;" class="modal hide fade modal-small" tabindex="-1" role="dialog" aria-labelledby="renameAlbumLabel" aria-hidden="true">
        <?php $attributes = array('id' => 'rename-album-form', 'class' => 'form-horizontal');
        echo form_open(base_url('album/rename_album'), $attributes); ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="renameAlbumLabel">Rename</h3>
        </div>
        <div class="modal-body">
          <div class="control-group">
              <div class="controls">
                <input type="hidden" id="old_album_name" name="old_album_name" value="<?php echo set_value('old_album_name');?>" placeholder="<?php echo $album_name;?>" spellcheck="false" />
              </div>
          </div>
          <div class="control-group">
              <div class="controls" style="margin-left: 75px;">
                <input type="text" id="new_album_name" name="new_album_name" value="<?php echo set_value('new_album_name');?>" placeholder="New Album Name" spellcheck="false" />
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-large btn-primary" id="rename-album-btn" value="Rename Album" />
          <div class="pull-left">
            <div class="error-message" style="margin-top: 10px;">Wrong album name</div>
          </div>
        </div>
        <?php echo form_close();?>
      </div>
      </div>
      <!-- END rename Form -->
      <!-- delete Form -->
      <div class="modal-container delete-album-modal">
      <div id="delete_album" style="margin: 50px auto;" class="modal hide fade modal-small" tabindex="-1" role="dialog" aria-labelledby="deleteAlbumLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="deleteAlbumLabel">Delete</h3>
        </div>
        <div class="modal-body">
          <p style="font-weight: bold;">Are you sure, you want to delete this album?</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Cancel</button>
          <input type="submit" class="btn btn-large btn-primary" id="delete-album-btn" value="Delete Album" />
          <div class="pull-left">
            <div class="error-message" style="margin-top: 10px;">please try later!</div>
          </div>
        </div>
      </div>
      </div>
      <!-- END delete Form -->
    <?php }?>
    <!-- comment Form -->
      <div class="modal-container comment-modal">
      <div id="comment" style="margin: 50px auto;" class="modal hide fade modal-comment" tabindex="-1" role="dialog" aria-labelledby="commentLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="commentLabel">Comment</h3>
        </div>
        <div class="modal-body" style="max-height: 600px;">
          <div class="control-group pull-right" style="width: 50%; margin: 0;">
            <h3 class="comment-title">Last Comments</h3>
            <!-- load comments here -->
            <div class="comments"></div>
          </div>
          <?php
            $attributes = array('id' => 'comment-form', 'class' => 'form-horizontal');
            echo form_open(base_url('home/comment_on_picture'), $attributes); ?>
          <div class="control-group pull-left" style="width: 50%; margin: 0;">
            <a href="#" target="_blank">
              <img class="thumbnail" id="commented-pic" style="margin-right: 5px; width: 330px; max-height: 450px; min-height: 175px; cursor: -webkit-zoom-in;" src="<?php echo base_url(IMAGES.'upload_picture.png'); ?>">
            </a>
            <textarea id="comment-content" rows="1" cols="30" style="resize: none; max-height: 64px; margin-top: 7%; width: 93%;" maxlength="100" placeholder="Write a comment..." spellcheck="false"></textarea>
            <button type="submit" class="btn btn-large btn-primary disabled" data-loading-text="Adding Comment..." id="add-comment-btn" style="width:93%; margin-top:3%; font-weight: bold;" disabled="disabled">Add Comment</button>
          </div>
          <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
          <div class="pull-left">
            <div class="error-message">We have a problem, please try later!</div>
          </div>
        </div>
      </div>
      </div>
    <!-- END comment Form -->

    <!-- pick Form -->
    <div class="modal-container pick-modal">
    <div id="pick" style="margin: 50px auto;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="pickLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="pickLabel">Repick</h3>
      </div>
      <div class="modal-body">
        <div class="control-group pull-right" style="width: 50%; margin-bottom: 0;">
          <div class="btn-group">
            <button style="width: 100%; height: 33px;" id="current-album" class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <strong style="float: left;">Select Album</strong>
              <span class="caret" style="float: right;"></span>
            </button>
            <ul id="album_list" class="dropdown-menu" style="width: 100%; max-height: 145px; overflow-x: hidden; overflow-y: auto;">
              <!-- dropdown menu links -->
              <div class="albums">
              <?php if($albums) {
                foreach ($albums as $album) { ?>
                  <li style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><a onClick="SetCurrentAlbum_repick(this.innerHTML)"><?php echo htmlspecialchars($album); ?></a></li>
                <?php }
              }?>
              </div>
              <li class="divider"></li>
              <li>
                <?php
                $attributes = array('id' => 'create-album-form', 'class' => 'form-horizontal');
                echo form_open(base_url('home/create_album'), $attributes); ?>
                  <input type="text" id="album_name" class="input-small pull-left" style="width: 64%; margin: 0 3% 3% 3%;" placeholder="Album Name" spellcheck="false" />
                  <button type="submit" class="btn pull-right" id="create-album-btn" data-loading-text="..."><strong>Create</strong></button>
                <?php echo form_close(); ?>
              </li>
            </ul>
          </div>
        </div>
        <?php
          $attributes = array('id' => 'repick-form', 'class' => 'form-horizontal');
          echo form_open(base_url('home/add_pic_to_album'), $attributes); ?>
        <a class="pull-left" href="#" target="_blank" style="width: 45%;">
          <img class="thumbnail" id="picked-pic" style="margin-right: 5px; width: 100%; max-height: 350px; min-height: 175px; cursor: -webkit-zoom-in;" src="<?php echo base_url(IMAGES.'upload_picture.png'); ?>">
        </a>
        <div class="control-group pull-right" style="width: 50%; margin-bottom: 0;">
          <textarea id="album-description" rows="3" cols="40" style="resize: none; margin-top: 10%; width: 96.5%;" maxlength="50" placeholder="Description" spellcheck="false"></textarea>
          <button type="submit" class="btn btn-large btn-primary disabled" data-loading-text="Picking..." id="repick-btn" style="width:100%; margin-top:5%; font-weight: bold;" disabled="disabled">Add Picture to Album</button>
        </div>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <div class="pull-left">
          <div class="error-message">Wrong album name</div>
        </div>
      </div>
    </div>
    </div>
    <!-- END pick Form -->