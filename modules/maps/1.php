<?
	//error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$markers= "var markers = [";
	$k = 0;
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode("|", $Worldspace);
		$x = 0;
		$y = 0;
		if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
		if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
			
		$description = "<h2><a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".htmlspecialchars($row['name'], ENT_QUOTES)." - ".$row['uid']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/models/".str_replace('"', '', $row['model']).".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left:".round(($y/100))." top:".round(((15360-$x)/100))."</td></tr></table>";
		$markers .= "['".htmlspecialchars($row['name'], ENT_QUOTES)."', '".$description."',".$y.", ".($x+1024).", ".$k++.", '".$path."images/icons/player".($row['death'] ? "_dead" : "").".png'],";

	}
	$markers .= "['Edge of map', 'Edge of Chernarus', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include ('modules/gm.php');
?>