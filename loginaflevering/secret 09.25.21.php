<?php
require_once("dbcon.php");
if(!isset($_SESSION["tjeklogin"])){
	echo "Du er ikke logget ind. Klik <a href=\"index.php\">her</a> for at logge ind";
} else {
?>
<!doctype html>
<html lang="da">
	<head>
		<title>Log in SYSTEM</title>
		<link rel="stylesheet" href="css.css">
	</head>
	<body>
	<p>
		DIN PERSONLIGE PROFIL....
	</p>
		<a href="logud.php">Log ud</a>
	</body>
</html>
<?php
	   }
?>