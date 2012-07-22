<?
if (isset($_SESSION['user_id']))
{	
	//if (isset($_GET["url"])){
		if (isset($_GET["kick"])){
			$cmd = "kick ".$_GET["kick"];
				
			$answer = rcon($serverip,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'index.php?view=table&show=0';
			</script>
			<?
		}
		if (isset($_GET["ban"])){
			$cmd = "Ban ".$_GET["ban"];
				
			$answer = rcon($serverip,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'index.php?view=table&show=0';
			</script>
			<?
		}
		if (isset($_POST["say"])){
			$id = "-1";
			if (isset($_GET["id"])){
				$id = $_GET["id"];
			}
			$cmd = "Say ".$id." ".$_POST["say"];
				
			$answer = rcon($serverip,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'index.php';
			</script>
			<?
		}
	//}
	?>
	<script type="text/javascript">
		window.location = 'index.php';
	</script>
	<?

	
	
}
else
{
	header('Location: index.php');
}
?>