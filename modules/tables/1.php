<?
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$pnumber = mysql_num_rows($res);			

	if(isset($_GET['page']))
	{
		$pageNum = $_GET['page'];
	}
	$offset = ($pageNum - 1) * $rowsPerPage;
	$maxPage = ceil($pnumber/$rowsPerPage);			

	for($page = 1; $page <= $maxPage; $page++)
	{
	   if ($page == $pageNum)
	   {
		  $nav .= " $page "; // no need to create a link to current page
	   }
	   else
	   {
		  $nav .= "$self&page=$page";
	   }
	}

	$query = $query." LIMIT ".$offset.",".$rowsPerPage;
	$res = mysql_query($query) or die(mysql_error());
	$number = mysql_num_rows($res);

	$tableheader = '
		<tr>
		<th class="table-header-repeat line-left" width="5%"><a href="">Status</a></th>
		<th class="table-header-repeat line-left" width="13%"><a href="">Player Name</a></th>
		<th class="table-header-repeat line-left" width="7%"><a href="">Player ID</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Inventory</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Backpack</a></th>
		</tr>';
		
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode("|", $Worldspace);
		$x = 0;
		$y = 0;
		if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
		if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
		
		$icon = '<img src="/images/icons/player'.($row['death'] ? '_dead' : '').'.png" title="" alt=""/>';
		
		$tablerows .= "<tr>
			<td align=\"center\">".$icon."</td>
			<td align=\"center\"><a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$row['name']."</a></td>
			<td align=\"center\"><a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$row['uid']."</a></td>
			<td align=\"center\">top:".round((154-($y/100)))." left:".round(($x/100))."</td>
			<td align=\"center\">".substr($row['inventory'], 0, 40) . "...</td>
			<td align=\"center\">".substr($row['backpack'], 0, 40) . "...</td>
		</tr>";
		}
	include ('paging.php');
?>