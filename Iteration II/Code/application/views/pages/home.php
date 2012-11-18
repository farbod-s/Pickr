<div class="container">
	<div id="holder">

    <!-- Top Message -->
    <div class="alert alert-error" style="margin-top: 1%;">
        <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
        <strong style="margin-right: 1%;">Welcome to Pickr!</strong>
        <span style="margin-right: 0.5%;">Need an account?</span>
        <!-- Button to trigger modal -->
        <a href="#signUp" role="button" class="btn btn-danger" data-toggle="modal"><strong>Sign Up</strong></a>
    </div>
    <!-- END Top Message -->

    <!-- SignUp Form -->
    <div id="signUp" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="signUpLabel" aria-hidden="true">
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
                <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" maxlength="20" minlength="4" placeholder="Username" spellcheck="false" required />
               </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="email">Email</label>
            <div class="controls">
               <div class="input-prepend">
                <span class="add-on"><i class="icon-envelope"></i></span>
                <input type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email" spellcheck="false" required />
               </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="password">Password</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span>
                <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" minlength="6" placeholder="Password" required />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="confirm_password">Confirm Password</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span>
                <input type="password" id="confirm_password" name="confirm_password" value="<?php echo set_value('confirm_password'); ?>" minlength="6" equalto="#password" placeholder="Confirm Password" required />
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
        <input type="submit" class="btn btn-large btn-primary" id="register-btn" style="width:100%; font-weight: bold;" value="Sign Up" />
      </div>
      <?php echo form_close(); ?>
    </div>
    <!-- END SignUp Form -->

    <!-- Load Pictures -->
    <?php
        for($i = 1; $i < 25; $i++) {
            if(($i % 4) == 1)
                echo '<div class="block">';
            echo '<div class="box">
                    <figure class="cap-bot">
                        <div class="inner-box" id="pic_'.$i.'" onMouseOver="ShowActions(this.id)" onMouseOut="HideActions(this.id)">
                            <span class="tool-box">
                                <a class="btn btn-small" href="#" onClick="Pick(this.parentNode.parentNode.id)"><i class="icon-star"></i></a>
                                <a class="btn btn-small" href="#" onClick="Comment(this.parentNode.parentNode.id)"><i class="icon-star"></i></a>
                                <a class="btn btn-small" href="#" onClick="Like(this.parentNode.parentNode.id)"><i class="icon-star"></i></a>
                            </span>
                            <a class="pic-link" href="#">
                                <img class="lazy" src="'.base_url().'resources/images/grey.gif" data-original="'.base_url().'resources/images/main/'.$i.'.jpg" alt="pic_'.$i.'" onLoad="OnImageLoad(event)" />
                            </a>
                        </div>
                        <figcaption>
                            <span>by unknown photographer</span>
                            <span class="record pull-right">
                                <i class="icon-comment icon-white record-img"></i> '.(2 * $i + 3).'
                                <i class="icon-heart icon-white record-img"></i> '.(2 * $i + 1).'
                            </span>
                        </figcaption>
                    </figure>
                </div>';
            if(($i % 4) == 0)
                echo '</div>';
        }
    ?>
    <!-- END Load Pictures -->

  </div>
  <button class="btn btn-large btn-block" id="btn-load" type="button"><b>More</b></button>
</div>
