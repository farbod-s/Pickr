<div class="container-fluid">
	<div id="holder">

    <!-- INITIAL BOXES, ALWAYS THE SAME -->

    <div class="box blue" id="pic-1"></div>
    <div class="box box-1" id="pic-2"></div>
    <div class="box box-2" id="pic-3"></div>
    <div class="box box-3" id="pic-4"></div>
    <div class="box box-4" id="pic-5"></div>
    <div class="box box-5" id="pic-6"></div>

    <!-- END -->
     
    <?php
        for($i = 7; $i < 26; $i++)
            echo '<div class="box" id="pic-'.$i.'"></div>';
    ?>
  </div>
  
  <button class="btn btn-large btn-block" type="button" style="margin-top: 20px; width: 100%;">Load More...</button>

</div>
