<?php
if (isset($_SESSION['user_id']))
{
?>
</div>
<!--  end content -->
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
 
</body>
</html>
<?php
}
else
{
	header('Location: index.php');
}
?>