<?php
ob_start();
require_once('db_con.php');
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
<!-- Form som henter data om log ind fra databasen -->
<?php
if(filter_input(INPUT_POST, 'submit')){
	$un = filter_input(INPUT_POST, 'un') 
		or die('Missing/illegal un parameter');
	$pw = filter_input(INPUT_POST, 'pw')
		or die('Missing/illegal pw parameter');
	
	$sql = 'SELECT id, username, password FROM login_table WHERE username=?';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('s', $un);
	$stmt->execute();
	$stmt->bind_result($id, $username, $password);
	$stmt->store_result(); //gemmer resultaterne til senere brug 
	
	
	if($stmt->num_rows == 1) { // Henter antallet af resultater, og ser om det er lige med 1
		while($stmt->fetch()){ //henter daterne 
			if (password_verify($pw, $password)){  //fører videre til næste side 
				$_SESSION["login_table"] = $username;
				$_SESSION["user_id"] = $id;
				
				echo "<script language='javascript' type='text/javascript'>";
				echo "alert('Du er logget ind')";
				echo "</script>";
				header("Location: secret.php");
				exit();
			}
			
			else{ // boks som kommer frem hvis kodeord ikke passer til brugernavnet
				echo "<script language='javascript' type='text/javascript'>";
				echo "alert('Forkert kodeord. Prøv en anden kombination.')";
				echo "</script>";
			}
		}
	} else { // boks som kommer frem hvis brugernavnet ikke findes
		echo "<script language='javascript' type='text/javascript'>";
				echo "alert('Brugeren findes ikke')";
				echo "</script>";
	}
}
	
?>
<!-- Log ind bokse -->
    
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<div class="login">
    	<p class="mig-tekst-php">LOG IND FOR AT ANMELDE</p>
    	<input class="login-boks" name="un" type="text" placeholder="Brugernavn" size="30" required/>
    	<input class="login-boks" name="pw" type="password" placeholder="Password" size="30"  required />
    	<input class="knap" name="submit" type="submit" value="LOG IND"/>
    	<div class="klik"><p>Har du ikke en bruger?<a href="opret.php"> Opret bruger her</a></p></div>
    	
	</div>
</form>


<div class="container">
<?php  // Data fra anmeldelser bliver hentet 
		$sql = 'SELECT headline, name, text_boks FROM text_table ORDER BY id_text DESC';
		$stmt = $con->prepare($sql);
		$stmt->bind_result($headline, $name, $text_boks);
		$stmt->execute();
	// data fra anmeldelser bliver vist
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