<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $title ?></title>

<meta name="viewport" content="width=device-width">
<meta name="keywords" content="<?php echo $keywords ?>" />
<meta name="author" content="<?php echo $author ?>" />
<meta name="description" content="<?php echo $description ?>" />

<link rel="stylesheet" href="<?php echo base_url(CSS."style.css");?>">
<link rel="stylesheet" href="<?php echo base_url(CSS."global.css");?>">

<!-- extra CSS-->
<?php foreach($css as $c):?>
<link rel="stylesheet" href="<?php echo base_url().CSS.$c?>">
<?php endforeach;?>

<!-- extra fonts-->
<?php foreach($fonts as $f):?>
<link href="http://fonts.googleapis.com/css?family=<?php echo $f?>"
	rel="stylesheet" type="text/css">
<?php endforeach;?>

<script src="<?php echo base_url(JS."libs/modernizr-2.5.3.min.js");?>"></script>

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="<?php echo base_url(IMAGES.'ico/favicon.ico');?>">
<link rel="apple-touch-icon" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-precompresse.png');?>">
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-57x57-precompressed.png');?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-72x72-precompressed.png');?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(IMAGES.'ico/apple-touch-icon-114x114-precompressed.png');?>">

<!-- Bootstrap Image Gallery styles -->
<!-- <link rel="stylesheet" href="http://localhost/www/codeigniter/assets/css/bootstrap-image-gallery.min.css"> -->
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<!-- <link rel="stylesheet" href="http://localhost/www/codeigniter/assets/css/jquery.fileupload-ui.css"> -->

<!--
<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="http://twitter.github.com/bootstrap/assets/css/docs.css" rel="stylesheet">
<link href="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.css" rel="stylesheet">

<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/jquery.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-transition.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-alert.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-modal.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-scrollspy.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tab.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-button.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-collapse.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-carousel.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-typeahead.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-affix.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/application.js"></script>
-->

</head>
<body onResize="FixImages(false)">
	<?php echo $body ?>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url(JS."libs/jquery-1.8.2.min.js");?>"><\/script>')</script>
	<script src="<?php echo base_url(JS."libs/jquery.validate.js");?>"></script>
	<script src="<?php echo base_url(JS."libs/underscore-1.3.1.min.js");?>"></script>
	<script src="<?php echo base_url(JS."libs/jquery.lazyload.js");?>"></script>
	<script src="<?php echo base_url(JS."plugins.js");?>"></script>
	<script src="<?php echo base_url(JS."script.js");?>"></script>
	<script src="<?php echo base_url(JS."validator.js");?>"></script>
	<script src="<?php echo base_url(JS."rotation.js");?>"></script>
	<script src="<?php echo base_url(JS."auth.js");?>"></script>
	<script src="<?php echo base_url(JS."libs/jquery.autosize.js");?>"></script>

	<!-- extra js-->
	<?php foreach($javascript as $js):?>
	<script defer src="<?php echo base_url().JS.$js?>"></script>
	<?php endforeach;?>
	<script type="text/javascript">
		$("img.lazy").lazyload({
			effect: "fadeIn"
		});
	</script>
<!--
	<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
-->
</body>
</html>
