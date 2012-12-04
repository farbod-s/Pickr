<?php echo $basejs ?>
<?php echo $header ?>
<div id="main" role="main" class="row">
	<?php echo $content_body; 
	$this->load->view("pages/upload");?>
</div>
<?php echo $footer ?>
