<?php
require_once("dbcon.php");
if(isset($_POST["opret"])){
	$brugernavn = $_POST["brugernavn"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	
	mysqli_query($con, "INSERT INTO bruger (username, password, email) VALUES ('{$brugernavn}','{$password}','{$email}')");
	echo "Bruger oprettet";
}
?>
<!doctype html>
<html lang="da">
	<head>
		<title>Log in SYSTEM</title>
		<link rel="stylesheet" href="css.css">
	</head>
	<body>
		<form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
			<input type="text" name="brugernavn" placeholder="Brugernavn">
			<input type="password" name="password" placeholder="Kodeord">
			<input type="email" name="email" placeholder="Email">
			<input type="submit" name="opret" value="Opret">
		</form>
	</body>
</html>