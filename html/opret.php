<?php 
session_start();
// require_once forbinder til databasen db_con.php
require_once("db_con.php"); 

// form som oprettet dig som bruger hvis alle boksene er udfyldt korrekt
if (filter_input(INPUT_POST, 'submit')){
	
	$un = filter_input(INPUT_POST, 'username')
		or die('Missing/illegal username parameter');
	
	$email = filter_input(INPUT_POST, 'email')
		or die('Missing/illegal password parameter');
	
	$pw = filter_input(INPUT_POST, 'password')
		or die('Missing/illegal password parameter');
	
	$pw = password_hash($pw, PASSWORD_DEFAULT);
	
	echo 'Creating user '.$un.' with password: '.$pw;
	 
	$sql= 'INSERT INTO login_table (username, email, password) VALUES (?, ?, ?)';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('sss', $un, $email, $pw);
	$stmt->execute(); 
	
	if ($stmt->affected_rows > 0) {  //fører videre til næste side som nu bliver: login.php
		echo 'user '.$un.' added ';
		$URL="login.php";
		echo "<script>location.href='$URL'</script>";
	}
	else {
		echo 'could not add user';
	}
}
?>

<!doctype html>
<html>
<head>
    <title>LashBeauty bar</title>
    <!-- Æ, ø og å -->
    <meta charset="utf-8">
    
    <!-- Så den også virker på smartphones -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="base.css">
   
    <link rel="stylesheet" type="text/css" href="medium.css" media="screen and (min-width: 650px)">

    <link rel="stylesheet" type="text/css" href="large.css" media="screen and (min-width: 900px)">
    
    <!-- Facebook og Instagram ikoner -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Burgermenu script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<a href="startside.html"><img src="billeder/logoet.svg" class="logo" alt="logo"></a>
    
    <!-- burgermenu - computer tilstand -->
    <nav class="desktop">        
        <a href="startside.html" class="desktop">OM KLINIKKEN</a>

        <!-- dropdown menu -->
        <div class="dropdown">
            <button class="dropbtn">BEHANDLINGER</button>
                <div class="dropdown-content">
                    <a href="lashes.html">VIPPER</a>
                    <a href="negle.html">NEGLE</a>
                    <a href="voks.html">VOKS</a>
                    <a href="hair.html">HÅR</a>
                    <a href="makeup.html">PERMANENT MAKEUP</a>
                    <a href="ansigtbehandling.html">ANSIGTS BEHANDLINGER</a>
                </div>
        </div>
        
        <a href="billeder.html" class="desktop">BILLEDER</a>
        <a href="javascript:voied();" onClick="popIt('http://salonbook.one/?lashbeautybar')" class="desktop">ONLINE BOOKING</a>
        <a href="login.php" class="desktop desktopaktiv">ANMELDELSER</a>

    </nav>
    
    <!-- burgermenu - mobil tilstand -->
    <nav class="mobile">
        <button></button>
			<div>
				<a href="startside.html">OM KLINIKKEN</a>
                <p>BEHANDLINGER</p>
                <a href="lashes.html" class="undermenu">- VIPPER</a>
                <a href="negle.html" class="undermenu">- NEGLE</a>
                <a href="voks.html" class="undermenu">- VOKS</a>
                <a href="hair.html" class="undermenu">- HÅR</a>
                <a href="makeup.html" class="undermenu">- PERMANENT MAKEUP</a>
                <a href="ansigtbehandling.html" class="undermenu">- ANSIGTSBEHANDLINGER</a>
				<a href="billeder.html">BILLEDER</a>
                <a href="javascript:voied();" onClick="popIt('http://salonbook.one/?lashbeautybar')" class="desktop">ONLINE BOOKING</a>
                <a href="login.php" class="mobilaktiv">ANMELDELSER</a>
			</div>
		</nav>
    <hr>

<!-- Dette er en placeholder til oprettelse af bruger -->


<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<div class="login">
    	<p class="mig-tekst-php">OPRET BRUGER</p>
    	<input class="login-boks" name="username" type="text" placeholder="Brugernavn" required />
    	<input class="login-boks" name="email" type="email" placeholder="Email" required />
    	<input class="login-boks" name="password" type="password" placeholder="Adgangskode" required />
    	<input class="knap" name="submit" type="submit" value="OPRET BRUGER" />
    </div>
</form>


<div class="klik"><p>Allerede bruger?<a href="login.php"> Log in her</a></p></div>

<div class="container">

<?php 
		$sql = 'SELECT headline, name, text_boks FROM text_table ORDER BY id_text DESC';
		$stmt = $con->prepare($sql);
		$stmt->bind_result($headline, $name, $text_boks);
		$stmt->execute();
	
	while($stmt->fetch()) {
		echo '<div class="postit">
				<div class="all_poster">
				<h3>Anmeldelse</h3>
				<li class="headline">'.$headline.'</li>
				<li class="name">'.$name.'</li>
				<li>'.$text_boks.'</li>
				</div>
			</div>';	
	}

?>
</div>

<footer>
        
    <!-- Instagram og Facebook ikoner som links -->
    <a href="javascript:voied();" onClick="popIt('https://www.instagram.com/lashbeautybar.dk/')"><i class="fa fa-instagram" style="font-size:70px"></i></a>
    <a href="javascript:voied();" onClick="popIt('https://www.facebook.com/lashbyheart/?fref=ts')"><i class="fa fa-facebook-f" style="font-size:68px"></i></a>
        
    <p>LashBeauty bar - Copyright © All Rights Reserved</p>
   

    </footer>


    
<!-- Burgermenu -->
<script src="burgermagic.js"></script>
    
<!-- Javascript, får links til at åbne i ny browser -->
<script src="javascript.js"></script>

</body>
</html>