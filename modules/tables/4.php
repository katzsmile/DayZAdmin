<?
		
	$exestatus = exec('tasklist /FI "IMAGENAME eq '.$gameexe.'" /FO CSV');
	$exestatus = explode(",", strtolower($exestatus));
	$exestatus = $exestatus[0];
	$exestatus = str_replace('"', "", $exestatus);
	
	if ($exestatus == strtolower($gameexe)){
		$serverrunning = true;
		$delresult .= '<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left">Server is online!</td>
					<td class="red-right"><a class="close-red"><img src="'.$path.'images/table/icon_close_red.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
	} else {
		$serverrunning = false;
		$delresult .= '<div id="message-yellow">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="yellow-left">Server is offline!</td>
					<td class="yellow-right"><a class="close-yellow"><img src='.$path.'images/table/icon_close_yellow.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
	}
	
	//////
	

	////
	
	if (isset($_POST["vehicle"])){
		$aDoor = $_POST["vehicle"];
		$N = count($aDoor);
		for($i=0; $i < $N; $i++)
		{
			$query2 = "SELECT * FROM objects WHERE id = ".$aDoor[$i].""; 
			$res2 = mysql_query($query2) or die(mysql_error());
			while ($row2=mysql_fetch_array($res2)) {
				$query2 = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('DELETE VEHICLE: ".$row2['otype']." - ".$row2['uid']."','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$query2 = "DELETE FROM `objects` WHERE id='".$aDoor[$i]."'";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$delresult .= '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">Vehicle '.$row2['otype'].' - '.$row2['uid'].' successfully removed!</td>
					<td class="green-right"><a class="close-green"><img src="'.$path.'images/table/icon_close_green.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
			}		
			//echo($aDoor[$i] . " ");
		}
		//echo $_GET["deluser"];
	}
	
	
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
	
	$chbox = "";
	
	if (!$serverrunning){ 
		$chbox = "<th class=\"table-header-repeat line-left\"><a href=\"\">Delete</a></th>";
		$formhead = '<form action="index.php?view=table&show=4" method="post">';
		$formfoot = '<input type="submit" class="submit-login"  /></form>';
	}
	
	$tableheader = header_vehicle(0, $chbox);
	
	if (!$serverrunning){ 
		$chbox = "<td class=\"gear_preview\"><input name=\"vehicle[]\" value=\"".$row['id']."\" type=\"checkbox\"/></td>";
	}	
	while ($row=mysql_fetch_array($res)) {
		$tablerows .= row_vehicle($row, $chbox);
	}
	include ('paging.php');
?>