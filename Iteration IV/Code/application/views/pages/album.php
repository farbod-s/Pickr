<div class="container">
	<?php
		$description = "";
		$album_name = "";
		$picks = count($pictures);

		if($album_info) {
			$album_name = $album_info[0]['name'];
			$description = $album_info[0]['description'];
		}
		//echo $description;
		//echo $album_name;
		//echo $picks;
		//echo $ME;
		//echo $username;
	?>

	<div class="profile-details">
		<div class="pull-left">
      <p style="padding: 25px 0 0 25px; font-size: 25px; font-weight: bold;"><?php echo $album_name; ?></p>
      <?php if(!$ME) { ?>
        <p style="padding: 10px 0 0 25px; font-size: 20px; font-weight: bold;">by <?php echo $username?></p>
      <?php }?>
        <p style="padding: 10px 0 0 25px; font-size: 20px;">Picks: <?php echo $picks?></p>
    </div>
    <div class="pull-right">
      <?php if(!$ME) {?>
        <button class="btn btn-large btn-danger" style="margin-top: 25px;">Follow Album</button>
      <?php } else {?>
        <button class="btn btn-large btn-danger delete-album-btn" style="margin: 25px 25px 0 0;">Delete Album</button>
        <a href="#rename_album" role="button" class="btn btn-large btn-danger" style="font-weight: normal; margin: 25px 0 0 0;" data-toggle="modal">Rename Album</a>

        <!-- rename Form -->
        <div id="rename_album" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="renameAlbumLabel" aria-hidden="true">
          <?php $attributes = array('id' => 'rename-album-form', 'class' => 'form-horizontal');
          echo form_open(base_url('album/rename_album'), $attributes); ?>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="renameAlbumLabel">Rename</h3>
          </div>
          <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="old_album_name">Old Name</label>
                <div class="controls">
                  <input type="text" class="uneditable-input" id="old_album_name" name="old_album_name" value="<?php echo set_value('old_name');?>" placeholder="<?php echo $album_name;?>" spellcheck="false" disabled />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="new_album_name">New Name</label>
                <div class="controls">
                  <input type="text" id="new_album_name" name="new_album_name" value="<?php echo set_value('new_album_name');?>" maxlength="50" minlength="4" placeholder="Album Name" spellcheck="false" required />
                </div>
            </div>
          </div>
          <div class="modal-footer"> 
            <input type="submit" class="btn btn-large btn-primary" id="rename-album-btn" style="width:100%; font-weight: bold;" value="Rename Album" />
          </div>
          <?php echo form_close();?>
        </div>
        <!-- END rename Form -->

      <?php }?>
    </div>
	</div>

	<div id="TitlePro">
        <h1>
            <span>Picks</span>
        </h1>
    </div>

	<!-- Load Pictures -->
    <div class="gallery" style="border-top: 1px solid #BFBFBF; padding-top: 5%;">
    <?php
    	if($pictures) {
    	$i = 0;
      foreach($pictures as $picture_path) { $i++; ?>
        <div class="article">
              <div class="frame">
                <figure class="cap-bot">
                  <div class="inner-box" id="albumPic_<?php echo $i; ?>">
                      <span class="tool-box">
                          <a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-magnet"></i></a>
                          <?php if(!$ME) {?>
                          <a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
                          <a class="btn btn-small like-btn" href="#"><i class="icon-thumbs-up"></i></a>
                          <?php } else {?>
                          <a class="btn btn-small delete-picture-btn" href="#"><i class="icon-trash"></i></a>
                          <?php }?>
                      </span>
                      <a class="pic-link" href="#">
                          <img id="albumPic_<?php echo $i; ?>" class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $picture_path; ?>" alt="albumPic_<?php echo $i; ?>" />
                      </a>
                      <figcaption>
                        <span>by unknown photographer</span>
                        <span class="record pull-right">
                            <i class="icon-comment icon-white record-img"></i> <span class="record-comment"><?php echo (2 * $i + 3); ?></span>
                            <i class="icon-heart icon-white record-img"></i> <span class="record-like"><?php echo (2 * $i + 1); ?></span>
                        </span>
                      </figcaption>
                  </div>
              </figure>
            </div>
        </div>
    <?php } } ?>
    </div>
  <!-- END Load Pictures -->

    <!-- pick Form -->
      <div id="pick" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="pickLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="pickLabel">Pick</h3>
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
                <?php if($albums) {
                  foreach ($albums as $album) { ?>
                    <li style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><a href="#" onClick="SetCurrentAlbum(this.innerHTML)"><?php echo $album; ?></a></li>
                  <?php }
                }?>
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
            $attributes = array('id' => 'pick-form', 'class' => 'form-horizontal');
            echo form_open(base_url('home/add_pic_to_album'), $attributes); ?>
          <a class="pull-left" href="#" style="width: 45%; height: 175px;">
            <img class="thumbnail" id="picked-pic" style="margin-right: 5px; width: 100%; height: 95%;" src="<?php echo base_url(IMAGES.'220x200.gif'); ?>">
          </a>
          <div class="control-group pull-right" style="width: 50%; margin-bottom: 0;">
            <textarea id="album-description" rows="3" cols="40" style="resize: none; margin-top: 10%; width: 96.5%;" maxlength="50" placeholder="Description" spellcheck="false"></textarea>
            <button type="submit" class="btn btn-large btn-primary disabled" data-loading-text="Picking..." id="add-to-album-btn" style="width:100%; margin-top:5%; font-weight: bold;" disabled="disabled">Add Picture to Album</button>
          </div>
          <?php echo form_close(); ?>
        </div>
        <div class="modal-footer"> 
        </div>
      </div>
    <!-- END pick Form -->

    <?php if(!$ME) {?>
      <!-- comment Form -->
        <div id="comment" class="modal hide fade modal-comment" tabindex="-1" role="dialog" aria-labelledby="commentLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="commentLabel">Comment</h3>
          </div>
          <div class="modal-body">
            <div class="control-group pull-right" style="width: 50%; margin: 0;">
              <h3 class="comment-title">Last Comments</h3>
              <!-- load comments here -->
              <div class="comments"></div>
            </div>
            <?php
              $attributes = array('id' => 'comment-form', 'class' => 'form-horizontal');
              echo form_open(base_url('home/comment_on_picture'), $attributes); ?>
            <div class="control-group pull-left" style="width: 50%; margin: 0;">
              <a href="#">
                <img class="thumbnail" id="commented-pic" style="margin-right: 5px; width: 330px; height: 250px;" src="<?php echo base_url(IMAGES.'220x200.gif'); ?>">
              </a>
              <textarea id="comment-content" rows="1" cols="30" style="resize: none; max-height: 64px; margin-top: 7%; width: 94.5%;" maxlength="100" placeholder="Write a comment..." spellcheck="false"></textarea>
              <button type="submit" class="btn btn-large btn-primary disabled" data-loading-text="Adding Comment..." id="add-comment-btn" style="width:94.5%; margin-top:3%; font-weight: bold;" disabled="disabled">Add Comment</button>
            </div>
            <?php echo form_close(); ?>
          </div>
          <div class="modal-footer"> 
          </div>
        </div>
      <!-- END comment Form -->
    <?php }?>

</div>