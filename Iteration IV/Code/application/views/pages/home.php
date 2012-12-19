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
          echo form_open('index.php/auth/register', $attributes); ?>

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
            <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
            <input type="submit" class="btn btn-large btn-primary" id="register-btn" style="width:100%; font-weight: bold;" value="Sign Up" />
          </div>
          
          <?php echo form_close();?>

        </div>
        <!-- END SignUp Form -->
    <?php } ?>

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
                          <a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-magnet"></i></a>
                          <a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
                          <a class="btn btn-small like-btn" href="#"><i class="icon-thumbs-up"></i></a>
                      </span><?php }?>
                      <a class="pic-link" href="#">
                          <img id="pic_<?php echo $i; ?>" class="lazy" src="<?php echo base_url();?>resources/images/grey.gif" data-original="<?php echo base_url();?>resources/images/main/<?php echo $i; ?>.jpg" alt="pic_<?php echo $i; ?>" />
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
                    <?php if($albums) {
                      foreach ($albums as $album) { ?>
                        <li><a href="#" onClick="SetCurrentAlbum(this.innerHTML)"><?php echo $album; ?></a></li>
                      <?php }
                    }?>
                    <li class="divider"></li>
                    <li>
                      <?php
                      $attributes = array('id' => 'create-album-form', 'class' => 'form-horizontal');
                      echo form_open(base_url('index.php/home/create_album'), $attributes); ?>
                        <input type="text" id="album_name" class="input-small pull-left" style="width: 64%; margin: 0 3% 3% 3%;" placeholder="Album Name" spellcheck="false" />
                        <button type="submit" class="btn pull-right" id="create-album-btn" data-loading-text="..."><strong>Create</strong></button>
                      <?php echo form_close(); ?>
                    </li>
                  </ul>
                </div>
              </div>
              <?php
                $attributes = array('id' => 'pick-form', 'class' => 'form-horizontal');
                echo form_open(base_url('index.php/home/add_pic_to_album'), $attributes); ?>
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
              <!-- TODO: load comments here -->
              <div class="control-group pull-right" style="width: 50%; margin: 0;">
                <h3 class="comment-title">Preview Comments</h3>
                <div class="comments">
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'ali-karimi.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Farbod Samsamipour</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      nice shot! ;)
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'naser.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Ehsan Nezhadian</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      chi migi? :-?
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'ali-karimi.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Farbod Samsamipour</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      to chi migi?
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'in.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Unknown User</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      chetorid ahmagha! :D
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'naser.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Ehsan Nezhadian</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      bebinamet haleto ja miaram.
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'ali-karimi.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Farbod Samsamipour</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      khafeh shid, ahhh! :(
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'in.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Unknown User</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz :D
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header">
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-flag"></i> Report Spam</a></li>
                        </ul>
                      </div>
                      <img src="<?php echo base_url(IMAGES.'naser.jpg');?>" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
                      <h4 class="commenter-name">Ehsan Nezhadian</h4>
                      <div class="commenter-date">12/18/2012 8:06:32</div>
                    </div>
                    <hr class="soft">
                    <div class="comment-body">
                      kesafat! ...
                    </div>
                  </div>
                </div>
              </div>
              <?php
                $attributes = array('id' => 'comment-form', 'class' => 'form-horizontal');
                echo form_open(base_url('index.php/home/comment_on_picture'), $attributes); ?>
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
    <?php } ?>

  </div>
  <button class="btn btn-large btn-block" id="btn-load" type="button"><b>More</b></button>
</div>

<button id="ScrollToTop" class="btn" type="button" style="display: none;">
  Scroll to Top
</button>