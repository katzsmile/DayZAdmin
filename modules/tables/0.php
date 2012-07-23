<?
	//ini_set( "display_errors", 0);
	//error_reporting (E_ALL ^ E_NOTICE);

	$cmd = "Players";
	
	$answer = rcon($serverip,$serverport,$rconpassword,$cmd);
	$tableheader = '
		<tr>
		<th class="table-header-repeat line-left" width="5%"><a href="">Status</a></th>
		<th class="table-header-repeat line-left" width="13%"><a href="">Player Name</a></th>
		<th class="table-header-repeat line-left" width="7%"><a href="">Player ID</a></th>
		<th class="table-header-repeat line-left" width="15%"><a href="">IP Address</a></th>
		<th class="table-header-repeat line-left" width="5%"><a href="">Ping</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Inventory</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Backpack</a></th>
		</tr>';
		
	
	if ($answer != ""){
		$k = strrpos($answer, "---");
		$l = strrpos($answer, "(");
		$out = substr($answer, $k+4, $l-$k-5);
		$array = preg_split ('/$\R?^/m', $out);
		
		//echo $answer."<br /><br />";
		
		$players = array();
		for ($j=0; $j<count($array); $j++){
			$players[] = "";
		}
		for ($i=0; $i < count($array); $i++)
		{
			$m = 0;
			for ($j=0; $j<5; $j++){
				$players[$i][] = "";
			}
			$pout = preg_replace('/\s+/', ' ', $array[$i]);
			for ($j=0; $j<strlen($pout); $j++){
				$char = substr($pout, $j, 1);
				if($m < 4){
					if($char != " "){
						$players[$i][$m] .= $char;
					}else{
						$m++;
					}
				} else {
					$players[$i][$m] .= $char;
				}
			}
		}
		/* for ($i=0; $i<count($players); $i++){
		for ($j=0; $j<count($players[$i]); $j++){
				echo $players[$i][$j]."  --  ".$j."<br /><br />";
		}
		} */
		
		$pnumber = count($players);
		//echo count($players)."<br />";
		for ($i=0; $i<count($players); $i++){
			//echo $players[$i][4]."<br />";
			if(strlen($players[$i][4])>1){
				$k = strrpos($players[$i][4], " (Lobby)");
				$playername = str_replace(" (Lobby)", "", $players[$i][4]);
				
				//$search = substr($playername, 0, 5);
				$paren_num = 0;
				$chars = str_split($playername);
				$new_string = '';
				foreach($chars as $char) {
					if($char=='[') $paren_num++;
					else if($char==']') $paren_num--;
					else if($paren_num==0) $new_string .= $char;
				}
				$playername = trim($new_string);


				//echo $playername."<br />";
				$search = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $playername);
				$good = trim(preg_replace("/\s(\S{1,2})\s/", " ", preg_replace("[ +]", "  "," $search ")));
				$good = trim(preg_replace("/\([^\)]+\)/", "", $good));
				$good = preg_replace("[ +]", " ", $good);
				//echo $good."<br />";
				$query = "SELECT * FROM main WHERE name LIKE '%". str_replace(" ", "%' OR name LIKE '%", $good). "%' ORDER BY lastupdate DESC LIMIT 1"; 				
				//echo $playername."<br />";
				$res = null;
				$res = mysql_query($query) or die(mysql_error());
				$dead = "";
				$x = 0;
				$y = 0;
				$inventory = "";
				$backpack = "";
				$ip = $players[$i][1];
				$ping = $players[$i][2];
				$name = $players[$i][4];
				$uid = "";
				
				while ($row=mysql_fetch_array($res)) {
					$Worldspace = str_replace("[", "", $row['pos']);
					$Worldspace = str_replace("]", "", $Worldspace);
					$Worldspace = explode("|", $Worldspace);					
					if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
					if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
					$x = round((154-($x/100)));
					$y = round(($y/100));
					$dead = ($row['death'] ? '_dead' : '');
					$inventory = substr($row['inventory'], 0, 40)."...";
					$backpack = substr($row['backpack'], 0, 40)."...";
					$name = "<a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$players[$i][4]."</a>";
					$uid = "<a href=\"index.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$row["uid"]."</a>";
					
				}
				$icon = '<a href="index.php?view=actions&kick='.$players[$i][0].'"><img src="'.$path.'images/icons/player'.$dead.'.png" title="Kick '.$players[$i][4].'" alt="Kick '.$players[$i][4].'"/></a>';
					
				$tablerows .= "<tr>
				<td align=\"center\"  style=\"vertical-align:middle;\">".$icon."</td>
				<td align=\"center\"  style=\"vertical-align:middle;\">".$name."</td>
				<td align=\"center\">".$uid."</td>
				<td align=\"center\">".$ip."</td>
				<td align=\"center\">".$ping."</td>
				<td align=\"center\">left:".$y." top:".$x."</td>
				<td align=\"center\">".$inventory."</td>
				<td align=\"center\">".$backpack."</td>
				<tr>";
			}
		}
	}

?>