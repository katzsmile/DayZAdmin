<? 
if (isset($_SESSION['user_id']))
{
	if (isset($_POST['type'])){
		$pagetitle = "Search for ".$_POST['type'];
	} else {
		$pagetitle = "New search";
	}
?>
<div id="page-heading">
<?
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";

?>
</div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?echo $path;?>images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?echo $path;?>images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<div id="content-table-inner">	
		<!--  start content-table-inner ...................................................................... START -->
		<?
		include ('searchbar.php');
		?><br/><?
		if (!empty($_POST))
		{
			//echo $_POST['search']."<br />".$_POST['type'];
			error_reporting (E_ALL ^ E_NOTICE);
			$search = substr($_POST['search'], 0, 64);
			$search = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $search);
			$good = trim(preg_replace("/\s(\S{1,2})\s/", " ", preg_replace("[ +]", "  "," $search ")));
			$good = preg_replace("[ +]", " ", $good);
			$logic = "OR";		
			
			
			switch ($_POST['type']) {
				case 'player':
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left" width="5%"><a href="">Status</a></th>
						<th class="table-header-repeat line-left" width="13%"><a href="">Player Name</a></th>
						<th class="table-header-repeat line-left" width="7%"><a href="">Player UID</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Inventory preview</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Backpack preview</a></th>
					</tr>
					<?
					$playerquery = "SELECT * FROM main WHERE name LIKE '%". str_replace(" ", "%' OR name LIKE '%", $good). "%' ORDER BY lastupdate DESC"; 
					$result = mysql_query($playerquery) or die(mysql_error());
					$tablerows = "";
					while ($row=mysql_fetch_array($result)) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
				break;
				case 'item':
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left" width="5%"><a href="">Status</a></th>
						<th class="table-header-repeat line-left" width="13%"><a href="">Player Name</a></th>
						<th class="table-header-repeat line-left" width="7%"><a href="">Player UID</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Backpack</a></th>
					</tr>
					<?
					$query = "SELECT * FROM main WHERE inventory LIKE '%". str_replace(" ", "%' OR backpack LIKE '%", $good). "%'"." ORDER BY lastupdate DESC";
					$result = mysql_query($query) or die(mysql_error());
					$tablerows = "";
					while ($row=mysql_fetch_array($result)) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
					break;
				case 'vehicle':
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left" width="5%"><a href="">ID</a></th>
						<th class="table-header-repeat line-left" width="13%"><a href="">Classname</a>	</th>
						<th class="table-header-repeat line-left" width="7%"><a href="">Object UID</a></th>
						<th class="table-header-repeat line-left" width="5%"><a href="">Damage</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Hitpoints</a></th>
					</tr>
					<?
					$query = "SELECT * FROM objects WHERE otype LIKE '%". str_replace(" ", "%' OR otype LIKE '%", $good). "%'";
					$res = mysql_query($query) or die(mysql_error());
					$chbox = "";
					while ($row=mysql_fetch_array($res)) {
							$tablerows .= row_vehicle($row, $chbox);
					}
					echo $tablerows;
					break;
				case 'container':
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left" width="5%"><a href="">ID</a></th>
						<th class="table-header-repeat line-left" width="13%"><a href="">Classname</a>	</th>
						<th class="table-header-repeat line-left" width="7%"><a href="">Object UID</a></th>
						<th class="table-header-repeat line-left" width="5%"><a href="">Damage</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Hitpoints</a></th>
					</tr>
					<?
					$query = "SELECT * FROM objects WHERE inventory LIKE '%". str_replace(" ", "%' OR inventory LIKE '%", $good). "%'";
					$chbox = "";
					while ($row=mysql_fetch_array($res)) {
							$tablerows .= row_vehicle($row, $chbox);
					}
					echo $tablerows;
					break;
				default:
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left" width="5%"><a href="">Status</a></th>
						<th class="table-header-repeat line-left" width="13%"><a href="">Player Name</a></th>
						<th class="table-header-repeat line-left" width="7%"><a href="">Player UID</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Inventory preview</a></th>
						<th class="table-header-repeat line-left" width="22%"><a href="">Backpack preview</a></th>
					</tr>
					<?
					$playerquery = "SELECT * FROM main WHERE name LIKE '%". str_replace(" ", "%' OR name LIKE '%", $good). "%' ORDER BY lastupdate DESC"; 
					$result = mysql_query($playerquery) or die(mysql_error());
					$tablerows = "";
					while ($row=mysql_fetch_array($result)) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
				};
			?>
			</table>
			<?
		}
		else
		{
		
		}
		?>		
		<!--  end content-table-inner ............................................END  -->
		</div>
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>
<?
}
else
{
	header('Location: index.php');
}
?>