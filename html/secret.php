<?php
ob_start();
require_once("db_con.php");

if(!isset($_SESSION["login_table"])){
	echo "Du er ikke logget ind. Klik <a href=\"login.php\">her</a> for at logge ind";
} else {
?>

<!doctype html>


<html lang="da">
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
	
	
		
<?php
// Data om anmeldelse hvis den bliver udfyldt korrekt
$text_boks = filter_input(INPUT_POST, 'text_boks', FILTER_SANITIZE_STRING);

	if(!empty($text_boks)){ // det der sker når man trykker på knappen
		
		$headline = filter_input(INPUT_POST, 'headline', FILTER_SANITIZE_STRING) or die('missing/illegal param headline');
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) or die('missing/illegal param name');
		$text_boks = filter_input(INPUT_POST, 'text_boks', FILTER_SANITIZE_STRING) or die('missing/illegal param text_boks');
		
		$sql = 'INSERT INTO text_table (headline, name, text_boks, user_id) VALUES (?, ?, ?, ?)';
		$stmt = $con->prepare($sql);
		$stmt->bind_param("sssi", $headline, $name, $text_boks, $_SESSION["user_id"]);
		$stmt->execute();

		}
	
?>

    
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="login">
            <p class="mig-tekst-php">
		DU ER NU LOGGET IND
	</p>
			<p class="anmeldelse">SKRIV DIN ANMELDELSE</p><br>
			<input class="login-boks" type="text" placeholder="Overskrift" name="headline" required>
			<input  class="login-boks" type="text" placeholder="Dit navn" name="name" required>
			<textarea class="post-boks" type="text" placeholder="Skriv din anmeldelse her" name="text_boks" required></textarea>
			<input class="knap" type="submit" name="post" value="POST">
			<div class="klik"><a href="logud.php">Log ud</a></div>
            </div>
		</form>

	
	<div class="container">
<?php 
		$sql = 'SELECT id_text, headline, name, text_boks, user_id FROM text_table ORDER BY id_text DESC';
		$stmt = $con->prepare($sql);
		$stmt->bind_result($id_text, $headline, $name, $text_boks, $uid);
		$stmt->execute();
	
	while($stmt->fetch()) {
		echo '<div class="postit">
				<div class="all_poster">
				<h3>Anmeldelser</h3>
				<li class="headline">'.$headline.'</li>
				<li>'.$name.'</li>
				<li>'.$text_boks.'</li><br>';
				
		if($uid == $_SESSION["user_id"]){
				echo '<a href="rename.php?id_text=' . $id_text . '">OPDATER &nbsp;
 </a> ';
				echo '<a href="delete.php?id_text=' . $id_text . '">&nbsp; SLET</a>';
		}
				echo '</div>
			</div>';	
	}
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
