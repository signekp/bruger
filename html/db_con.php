
<?php 
session_start();
 
const HOSTNAME = 'signepetersen.dk.mysql'; // server navn
const MYSQLUSER = 'signepetersen_dk_3semester_eksamen'; // super bruger (remote har man særskilte database brugere)
const MYSQLPASS = 'banankage'; // bruger password
const MYSQLDB = 'signepetersen_dk_3semester_eksamen'; // database navn 


$con = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

$con->set_charset('utf-8');


if($con->connect_error){ 
	die($con->connect_error);
}

?>
