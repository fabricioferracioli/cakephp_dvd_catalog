<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout; ?></title>
	<?php
	echo $html->charset();
	echo $html->css('cakecatalog');
	echo $scripts_for_layout;

	// if the javscript helper is set include the javascript library
	if(isset($javascript)) {
		echo $javascript->link(array('jquery-1.2.3.pack', 'common'), true);
	}
	?>
</head>
<body>
<div id="wrapper-header">
	<div id="header">
		<div class="logo">
			<h1>CakeCatalog</h1>
			<h2>an online application to track and catalog your collection of dvds built using cakephp</h2>
		</div>
	</div>
</div>
<?php
// echo out view code
echo $content_for_layout;
// include a footer element
echo $this->element('index_footer');
// if debug is on echo to screen
//echo $cakeDebug;
?>
</body>
</html>