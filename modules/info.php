<? 
$debug = '';
//ob_end_clean();
if (isset($_SESSION['user_id']))
{
	include ('/info/'.$show.'.php');
}
else
{
	header('Location: index.php');
}
//ob_end_clean();
?>