<? 
if (isset($_SESSION['user_id']))
{

ini_set( "display_errors", 0);
error_reporting (E_ALL ^ E_NOTICE);
require_once 'GameQ.php';

$pagetitle = "Dashboard";

$logs = "";
$query = "SELECT * FROM `logs` ORDER BY `timestamp` DESC LIMIT 100";
$res = mysql_query($query) or die(mysql_error());
while ($row=mysql_fetch_array($res)) {
	$logs .= $row['timestamp'].' '.$row['user'].': '.$row['action'].chr(13);
}
$xml = file_get_contents('/quicklinks.xml', true);

require_once('xml2array.php');
$quicklinks = XML2Array::createArray($xml);

// Define your servers,
// see list.php for all supported games and identifiers.
$servers = array(
    'server 1' => array('armedassault2', $serverip)
);


// Call the class, and add your servers.
$gq = new GameQ();
$gq->addServers($servers);
    
// You can optionally specify some settings
$gq->setOption('timeout', 200);


// You can optionally specify some output filters,
// these will be applied to the results obtained.
$gq->setFilter('normalise');
$gq->setFilter('sortplayers', 'gq_ping');

// Send requests, and parse the data
$oresults = $gq->requestData();
//print_r($oresults);
// Some functions to print the results
function print_results($oresults) {

    foreach ($oresults as $id => $data) {

        //printf("<h2>%s</h2>\n", $id);		
        print_table($data);
    }

}

function print_table($data) {  

	if (!$data['gq_online']) {
		printf("<p>The server did not respond within the specified time.</p>\n");
		return;
	}			
	?>
	<!--  start table-content  -->
			<h2><? echo $data['gq_hostname']; ?></h2>
			<h2>Address:</h2><h3><? echo $data['gq_address']; ?>:<? echo $data['gq_port']; ?></h3>
			<h2>Mods:</h2><h3><? echo $data['gq_mod']; ?></h3>
			<h2>Max players:</h2><h3><? echo $data['gq_maxplayers']; ?></h3>
			<h2>Online players:</h2><h3><? echo $data['gq_numplayers']; ?></h3>	
		<!--  end table-content  -->
	<?
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
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="50%">	
					<?	
						print_results($oresults);
					?>
				</td>
				<td width="50%">
					<?	
						include ('say.php');
					?>
				</td>		
			</tr>
		</table>
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
			<tr>
				<th class="table-header-repeat line-left minwidth-1"><a href="">Quick links</a>	</th>
				<th class="table-header-repeat line-left minwidth-1"><a href="">Actions log</a></th>
			</tr>
			<tr>
				<td align="center" width="50%">
					<div id="quicklinks">
						<ul>
						<?php foreach ($quicklinks['quicklinks'] as $ql) : ?>
							<?php if ($ql != null) : ?>
							<li>
								<a href="<?php echo $ql['Link']; ?>" style="color: #000;">
									<span class="quicklink-box">
										<img src="<?echo $path;?>images/icons/<?php echo $ql['Icon']; ?>" alt="<?php echo $ql['Name']; ?>" /><br />
										<strong><?php echo $ql['Name']; ?></strong>
									</span>
								</a>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>
					</div>
				</td>
				<td align="center" width="50%">
					<textarea cols="68" rows="12" readonly><?php echo $logs; ?></textarea>
				</td>	
			</tr>				
		</table>			
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