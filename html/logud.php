<?php
ob_start();
require_once("db_con.php");


if(!isset($_SESSION["tjeklogin"])){ 
	
	header("Location: login.php");
} else {
	session_destroy(); //hvis du er logget ind, sletter den oplysninger og føre dig videre til opret.php
	header("Location: login.php");
}
?>
