<?php
if (isset($_SESSION['user_id']))
{

	switch ($show) {
		case 0:
			$pagetitle = "Online players";
			break;
		case 1:
			$query = "SELECT * FROM main WHERE death = 0"; 
			$pagetitle = "Alive players";		
			break;
		case 2:
			$query = "SELECT * FROM main WHERE death = 1"; 
			$pagetitle = "Dead players";	
			break;
		case 3:
			$query = "SELECT * FROM main"; 
			$pagetitle = "All players";	
			break;
		case 4:
			$query = "SELECT * FROM objects";
			$pagetitle = "Ingame vehicles";	
			break;
		case 5:
			$query = "SELECT * FROM spawns";
			$pagetitle = "Vehicle spawn locations";	
			break;
		default:
			$pagetitle = "Online players";
		};

?>
<div id="page-heading">
<?
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";
?>
</div>
<?
	include ('/maps/'.$show.'.php');
}
else
{
	header('Location: index.php');
}
?> 
