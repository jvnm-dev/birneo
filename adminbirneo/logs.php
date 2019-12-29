<?php 
	include("../res/config.php");
	if(isset($_SESSION['adminbirneo']) && $_SESSION['adminbirneo'] != '')
	{

	}else
	{
		header("Location: ../home");
	}
?>
<html>
<head>
	<title>Logs</title>
	<meta charset="utf-8" />
</head>
<body>
	<?php require("../logs/admin.txt"); ?>
</body>
</html>