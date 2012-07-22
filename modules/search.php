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
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
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
						<th class="table-header-repeat line-left minwidth-1"><a href="">Player Name</a>	</th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Player ID</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Character ID</a></th>
						<th class="table-header-repeat line-left"><a href="">Alive</a></th>
						<th class="table-header-repeat line-left"><a href="">Position</a></th>
						<th class="table-header-repeat line-left"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left"><a href="">Backpack</a></th>
					</tr>
					<?
					$playerquery = "SELECT * FROM main WHERE name LIKE '%". str_replace(" ", "%' OR name LIKE '%", $good). "%' ORDER BY lastupdate DESC"; 
					$result = mysql_query($playerquery) or die(mysql_error());
					while ($player=mysql_fetch_array($result)) {
						$Worldspace = str_replace("[", "", $player['pos']);
						$Worldspace = str_replace("]", "", $Worldspace);
						$Worldspace = str_replace("|", ",", $Worldspace);
						$Worldspace = explode(",", $Worldspace);
						echo "<tr>
						<td><a href=\"index.php?view=info&show=1&id=".$player['uid']."&cid=".$player['id']."\">".$player['name']."</a></td>
						<td><a href=\"index.php?view=info&show=1&id=".$player['uid']."&cid=".$player['id']."\">".$player['uid']."</a></td>
						<td><a href=\"index.php?view=info&show=1&id=".$player['uid']."&cid=".$player['id']."\">".$player['id']."</a></td>
						<td>".($player['death'] ? "No" : "Yes")."</td>
						<td>left:".round(($Worldspace[1]/100))." top:".round((154-($Worldspace[2]/100)))."</td>
						<td>".substr($player['inventory'], 0, 50) . "...</td>
						<td>".substr($player['backpack'], 0, 50) . "...</td>
						</tr>";
					}					
				break;
				case 'item':
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Player Name</a>	</th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Player ID</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Character ID</a></th>
						<th class="table-header-repeat line-left"><a href="">Alive</a></th>
						<th class="table-header-repeat line-left"><a href="">Position</a></th>
						<th class="table-header-repeat line-left"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left"><a href="">Backpack</a></th>
					</tr>
					<?
					$query = "SELECT * FROM main WHERE inventory LIKE '%". str_replace(" ", "%' OR backpack LIKE '%", $good). "%'"." ORDER BY lastupdate DESC";
					$res = mysql_query($query) or die(mysql_error());
					while ($row=mysql_fetch_array($res)) {
						$Worldspace = str_replace("[", "", $row['pos']);
						$Worldspace = str_replace("]", "", $Worldspace);
						$Worldspace = str_replace("|", ",", $Worldspace);
						$Worldspace = explode(",", $Worldspace);
						echo "<tr>
						<td><a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$row['name']."</a></td>
						<td><a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$row['uid']."</a></td>
						<td><a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$row['id']."</a></td>
						<td>".($row['death'] ? "No" : "Yes")."</td>
						<td>left:".round(($Worldspace[1]/100))." top:".round((154-($Worldspace[2]/100)))."</td>
						<td>".substr($row['inventory'], 0, 50) . "...</td>
						<td>".substr($row['backpack'], 0, 50) . "...</td>
						</tr>";
					}
					break;
				case 'vehicle':
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Classname</a>	</th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Object UID</a></th>
						<th class="table-header-repeat line-left"><a href="">Damage</a></th>
						<th class="table-header-repeat line-left"><a href="">Position</a></th>
						<th class="table-header-repeat line-left"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left"><a href="">Hitpoints</a></th>
					</tr>
					<?
					$query = "SELECT * FROM objects WHERE otype LIKE '%". str_replace(" ", "%' OR otype LIKE '%", $good). "%'";
					$res = mysql_query($query) or die(mysql_error());
					while ($row=mysql_fetch_array($res)) {
							$Worldspace = str_replace("[", "", $row['pos']);
							$Worldspace = str_replace("]", "", $Worldspace);
							$Worldspace = str_replace("|", ",", $Worldspace);
							$Worldspace = explode(",", $Worldspace);
							echo "<tr>
							<td><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['otype']."</a></td>
							<td><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['id']."</a></td>
							<td>".$row['damage']."</td>
							<td>left:".round(($Worldspace[1]/100))." top:".round((154-($Worldspace[2]/100)))."</td>							
							<td>".substr($row['inventory'], 0, 50) . "...</td>
							<td>".substr($row['hitpoints'], 0, 50) . "...</td>
							</tr>";
					}
					break;
				case 'container':
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Classname</a>	</th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Object UID</a></th>
						<th class="table-header-repeat line-left"><a href="">Damage</a></th>
						<th class="table-header-repeat line-left"><a href="">Position</a></th>
						<th class="table-header-repeat line-left"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left"><a href="">Hitpoints</a></th>
					</tr>
					<?
					$query = "SELECT * FROM objects WHERE inventory LIKE '%". str_replace(" ", "%' OR inventory LIKE '%", $good). "%'";
					$res = mysql_query($query) or die(mysql_error());
					while ($row=mysql_fetch_array($res)) {
							$Worldspace = str_replace("[", "", $row['pos']);
							$Worldspace = str_replace("]", "", $Worldspace);
							$Worldspace = str_replace("|", ",", $Worldspace);
							$Worldspace = explode(",", $Worldspace);
							echo "<tr>
							<td><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['otype']."</a></td>
							<td><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['id']."</a></td>
							<td>".$row['damage']."</td>
							<td>left:".round(($Worldspace[1]/100))." top:".round((154-($Worldspace[2]/100)))."</td>							
							<td>".substr($row['inventory'], 0, 50) . "...</td>
							<td>".substr($row['hitpoints'], 0, 50) . "...</td>
							</tr>";
					}
					break;
				default:
					?>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Player Name</a>	</th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Player ID</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Character ID</a></th>
						<th class="table-header-repeat line-left"><a href="">Alive</a></th>
						<th class="table-header-repeat line-left"><a href="">Position</a></th>
						<th class="table-header-repeat line-left"><a href="">Inventory</a></th>
						<th class="table-header-repeat line-left"><a href="">Backpack</a></th>
					</tr>
					<?
					$playerquery = "SELECT * FROM main WHERE name LIKE '%". str_replace(" ", "%' OR name LIKE '%", $good). "%' ORDER BY lastupdate DESC"; 
					$result = mysql_query($playerquery) or die(mysql_error());
					while ($player=mysql_fetch_array($result)) {
						$Worldspace = str_replace("[", "", $player['pos']);
						$Worldspace = str_replace("]", "", $Worldspace);
						$Worldspace = str_replace("|", ",", $Worldspace);
						$Worldspace = explode(",", $Worldspace);
						echo "<tr>
						<td><a href=\"index.php?view=info&show=1&id=".$player['uid']."&cid=".$player['id']."\">".$player['name']."</a></td>
						<td><a href=\"index.php?view=info&show=1&id=".$player['uid']."&cid=".$player['id']."\">".$player['uid']."</a></td>
						<td><a href=\"index.php?view=info&show=1&id=".$player['uid']."&cid=".$player['id']."\">".$player['id']."</a></td>
						<td>".($player['death'] ? "No" : "Yes")."</td>
						<td>left:".round(($Worldspace[1]/100))." top:".round((154-($Worldspace[2]/100)))."</td>
						<td>".substr($player['inventory'], 0, 50) . "...</td>
						<td>".substr($player['backpack'], 0, 50) . "...</td>
						</tr>";
					}
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