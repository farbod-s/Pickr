<?php
  $is_logged_in = $this->tank_auth->is_logged_in(); 
?>
<div class="container">
	<div id="holder">

    <?php if (!$is_logged_in) { ?>
        <!-- Top Message -->
        <div class="alert alert-error" style="margin: 1%;">
            <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
            <strong style="margin-right: 1%;">Welcome to Pickr!</strong>
            <span style="margin-right: 0.5%;">Need an account?</span>
            <!-- Button to trigger modal -->
            <a href="#signUp" role="button" class="btn btn-danger" data-toggle="modal"><strong>Sign Up</strong></a>
        </div>
        <!-- END Top Message -->

        <!-- SignUp Form -->
        <div id="signUp" style="width: 500px;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="signUpLabel" aria-hidden="true">
        
        <?php $attributes = array('id' => 'register-form', 'class' => 'form-horizontal');
          echo form_open(base_url('auth/register'), $attributes); ?>

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="signUpLabel">Create Account</h3>
          </div>
          <div class="modal-body">
            <!-- <form class="form-horizontal" id="register-form" action=""> -->
              <div class="control-group">
                <label class="control-label" for="username">Username</label>
                <div class="controls">
                   <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" id="username" name="username" value="<?php echo set_value('username');?>" maxlength="20" minlength="4" placeholder="Username" spellcheck="false" required />
                   </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                   <div class="input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <input type="email" id="email" name="email" value="<?php echo set_value('email');?>" placeholder="Email" spellcheck="false" required />
                   </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input type="password" id="password" name="password" value="<?php echo set_value('password');?>" minlength="6" placeholder="Password" required />
                  </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="confirm_password">Confirm Password</label>
                <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input type="password" id="confirm_password" name="confirm_password" value="<?php echo set_value('confirm_password');?>" minlength="6" equalto="#password" placeholder="Confirm Password" required />
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-large btn-primary" id="register-btn" value="Sign Up" />
            <div class="pull-left">
              <div class="error-message">Username or Email is duplicated</div>
            </div>
          </div>
          
          <?php echo form_close();?>

        </div>
        <!-- END SignUp Form -->
    <?php } ?>



    <!-- Load Pictures -->
    <?php if ($is_logged_in) { ?>
    <div class="gallery" id="infinite_loop">
      <?php
      //print_r($followed_pictures);
      foreach($followed_pictures as $pic => $pic_id) { ?>
        <div class="article">
              <div class="frame">
                <figure class="cap-bot">
                  <div class="inner-box" id="pic_<?php echo $pic_id; ?>">
                    <?php
                      if ($is_logged_in) { ?>
                      <span class="tool-box">
                          <a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-magnet"></i> Pick</a>
                          <a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
                          <a class="btn btn-small like-btn" href="#"><i class="icon-thumbs-up"></i></a>
                      </span><?php }
                      ?>
                      <a class="pic-link" href="#">
                          <img id="pic_<?php echo $pic_id; ?>" class="lazy" src="<?php echo $pic ?>" data-original="<?php echo $pic ?>" alt="pic_<?php echo $pic_id; ?>" />
                      </a> <?php  ?>
                        <figcaption>
                        <span>by unknown photographer</span>
                        <span class="record pull-right">
                            <i class="icon-comment icon-white record-img"></i> <span class="record-comment"><?php echo (2 * $pic_id + 3); ?></span>
                            <i class="icon-heart icon-white record-img"></i> <span class="record-like"><?php echo (2 * $pic_id + 1); ?></span>
                        </span>
                    </figcaption>
                  </div>
              </figure>
            </div>
        </div> 
    <?php } ?>    
    </div>
    <?php } ?>

   <?php if (!$is_logged_in) { ?>
    <!-- Load Pictures -->
    <div class="gallery">
    <?php 
      for($i = 1; $i < 25; $i++) { ?>
        <div class="article">
              <div class="frame">
                <figure class="cap-bot">
                  <div class="inner-box" id="pic_<?php echo $i; ?>">
                    <?php
                      if ($is_logged_in) { ?>
                      <span class="tool-box">
                          <a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-magnet"></i> Pick</a>
                          <a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
                          <a class="btn btn-small like-btn" href="#"><i class="icon-thumbs-up"></i></a>
                      </span><?php }?>
                      <a class="pic-link" href="#">
                          <img id="pic_<?php echo $i; ?>" class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo base_url(IMAGES.'main/'.$i.'.jpg');?>" alt="pic_<?php echo $i; ?>" />
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
    <?php } ?>
    </div>
    <?php } ?>
    <!-- END Load Pictures -->    

    <?php
      if ($is_logged_in) { ?>

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
                    <div class="albums">
                    <?php if($albums) {
                      foreach ($albums as $album) { ?>
                        <li style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><a onClick="SetCurrentAlbum(this.innerHTML)"><?php echo htmlspecialchars($album); ?></a></li>
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
              <div class="pull-left">
                <div class="error-message">Correct album name</div>
              </div>
            </div>
          </div>
          <!-- END pick Form -->
    <?php } ?>

    <?php
      if ($is_logged_in) { ?>

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
              <div class="pull-left">
                <div class="error-message">We have a problem, please try later!</div>
              </div>
            </div>
          </div>
          <!-- END comment Form -->
    <?php } ?>

  </div>
  <button class="btn btn-large btn-block" id="btn-load" type="button"><b>More</b></button>
</div>