<?php echo $basejs ?>
<?php echo $header ?>
<div id="main" role="main" class="row">
	<?php echo $content_body; 

	// upload form
	$this->load->view("pages/upload");?>

	<button id="ScrollToTop" class="btn" type="button" style="display: none;">
	  Scroll to Top
	</button>
</div>
<?php echo $footer ?>
