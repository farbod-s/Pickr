<div class="container">
	<div id="holder">

    <!-- <img src="..." onLoad="OnImageLoad(event);" /> -->
    <!-- <i class="icon-eye-open icon-white record-img"></i> '.($i + 5).' -->

    <div class="alert alert-error" style="margin-top: 1%;">
        <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
        <strong style="margin-right: 5%;">Welcome to Pickr!</strong><span style="margin-right: 0.5%;">Need an account?</span>
        <!-- Button to trigger modal -->
        <a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal">Sign up Here</a>
         
        <!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Sign Up</h3>
          </div>
          <div class="modal-body">
            <p>One fine body…</p>
          </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-primary">Save changes</button>
          </div>
        </div>
    </div>

    <?php
        for($i = 1; $i < 26; $i++) {
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
                                <img class="lazy" src="'.base_url().'resources/images/grey.gif" data-original="'.base_url().'resources/images/main/'.$i.'.jpg" alt="pic_'.$i.'" />
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

  </div>
  <button class="btn btn-large btn-block" id="btn-load" type="button"><b>More</b></button>
</div>
