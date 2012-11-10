<div class="container-fluid">
	<div id="holder">

    <!-- INITIAL BOXES, ALWAYS THE SAME -->
<!--
    <div class="box blue" id="pic-1"></div>
    <div class="box box-1" id="pic-2"></div>
    <div class="box box-2" id="pic-3"></div>
    <div class="box box-3" id="pic-4"></div>
    <div class="box box-4" id="pic-5"></div>
    <div class="box box-5" id="pic-6"></div>
-->
    <!-- END -->
    
    <!-- <img onload="OnImageLoad(event);" /> -->

    <?php
        for($i = 1; $i < 26; $i++) {
            echo '<div class="box" id="pic_'.$i.'" onMouseOver="ShowActions(this.id)" onMouseOut="HideActions(this.id)">
                    <span class="tool-box">
                        <button type="submit" class="btn" onClick="Pick(this.parentNode.parentNode.id)">Pick it</button>
                        <button type="submit" class="btn" onClick="Like(this.parentNode.parentNode.id)">Like</button>
                        <button type="submit" class="btn" onClick="Comment(this.parentNode.parentNode.id)"><i class="icon-comment"></i> Comment</button>
                    </span>
                    <span><img src="'.base_url().'/resources/images/main/'.$i.'.jpg" onLoad="OnImageLoad(event);" /></span>
                </div>';
        }
    ?>
  </div>
  
  <button class="btn btn-large btn-block" id="btn-load" type="button">Load More...</button>

</div>
