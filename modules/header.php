<?php
if (isset($_SESSION['user_id']))
{
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<link rel="stylesheet" href="css/menu.css" />	
<link rel="stylesheet" href="css/watch.css" />	
<link rel="stylesheet" href="css/flexcrollstyles.css" />	
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>	
<script src="js/flexcroll.js" type="text/javascript"></script>
<!--<script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery/ui.core.js" type="text/javascript"></script>
<script src="js/jquery/ui.checkbox.js" type="text/javascript"></script>
<script src="js/jquery/jquery.bind.js" type="text/javascript"></script>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>

 Custom jquery scripts 
<script src="js/jquery/custom_jquery.js" type="text/javascript"></script>-->
 
<!-- Tooltips
<script src="js/jquery/jquery.tooltip.js" type="text/javascript"></script>
<script src="js/jquery/jquery.dimensions.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
});
</script> -->

<script src="js/modalpopup.js" type="text/javascript"></script>
</head>
<body> 
<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo">
		<a href=""><img src="<?echo $path;?>images/logo.png" width="150px" height="72px" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<!-- start watch -->

	<!-- end watch -->
	
	<!--  start top-search -->
	<div id="top-search">
	<? 
	include ('searchbar.php');
	?>
	</div>
 	<!--  end top-search -->
 	<div class="clear"></div>

</div>
<!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
	
<div class="clear">&nbsp;</div>
 
<? 
include ('navbar.php');
?>
 <div class="clear"></div>
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">
<?
}
else
{
	header('Location: index.php');
}
?>