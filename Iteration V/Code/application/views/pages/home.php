<?php
  $is_logged_in = $this->tank_auth->is_logged_in(); 
?>

<!-- Load Pictures -->
  <ul id="tiles">
    <?php if (!$is_logged_in) { ?>
    <li>
      <!-- Top Message -->
      <div class="alert alert-error" style="margin: 1%;">
        <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
        <div style="margin-bottom: 10px; font-size: 17px; font-weight: bold;">Welcome to Pickr</div>
        <div style="margin-bottom: 20px; font-size: 13px; font-weight: bold;">Need an account?</div>
        <!-- Button to trigger modal -->
        <a href="#signUp" role="button" class="btn btn-danger" data-toggle="modal" style="width: 100%; line-height: 22px;"><strong>Sign Up</strong></a>
      </div>
      <!-- END Top Message -->
    </li>
    <?php } ?>
    <!-- Load Here -->
  </ul>
<!-- END Load Pictures -->  

<div id="loader">
  <div id="loaderCircle"></div>
  <div id="finished">Congratulations, You see all! :)</div>
</div>

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
          <a class="pull-left" href="#" style="width: 45%;">
            <img class="thumbnail" id="picked-pic" style="margin-right: 5px; width: 100%; max-height: 350px; min-height: 175px;" src="<?php echo base_url(IMAGES.'upload_picture.png'); ?>">
          </a>
          <div class="control-group pull-right" style="width: 50%; margin-bottom: 0;">
            <textarea id="album-description" rows="3" cols="40" style="resize: none; margin-top: 10%; width: 96.5%;" maxlength="50" placeholder="Description" spellcheck="false"></textarea>
            <button type="submit" class="btn btn-large btn-primary disabled" data-loading-text="Picking..." id="add-to-album-btn" style="width:100%; margin-top:5%; font-weight: bold;" disabled="disabled">Add Picture to Album</button>
          </div>
          <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
          <div class="pull-left">
            <div class="error-message">Wrong album name</div>
          </div>
        </div>
      </div>
      <!-- END pick Form -->

      <!-- comment Form -->
      <div id="comment" class="modal hide fade modal-comment" tabindex="-1" role="dialog" aria-labelledby="commentLabel" aria-hidden="true">
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
            <a href="#">
              <img class="thumbnail" id="commented-pic" style="margin-right: 5px; width: 330px; max-height: 450px; min-height: 175px;" src="<?php echo base_url(IMAGES.'upload_picture.png'); ?>">
            </a>
            <textarea id="comment-content" rows="1" cols="30" style="resize: none; max-height: 64px; margin-top: 7%; width: 93%;" maxlength="100" placeholder="Write a comment..." spellcheck="false"></textarea>
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
<?php } else { ?>
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
          <div class="error-message" style="margin-top: 10px;">Username or Email is duplicated</div>
        </div>
      </div>
      <?php echo form_close();?>
    </div>
    <!-- END SignUp Form -->
<?php } ?>