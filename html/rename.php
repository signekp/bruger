<?php
require_once('db_con.php');

if($cmd = filter_input(INPUT_POST, 'cmd')){
	
		$cid = filter_input(INPUT_POST, 'id_text', FILTER_VALIDATE_INT)
			or die('Missing/illegal id_text parameter');
		$cnam = filter_input(INPUT_POST, 'headline')
			or die('Missing/illegal categoryname parameter');
	
		$txt = filter_input(INPUT_POST, 'text_boks')
			or die('Missing/illegal categoryname parameter');
		
		$sql = 'UPDATE text_table SET headline=?, text_boks=? WHERE id_text=?';
		$stmt = $con->prepare($sql);
		$stmt->bind_param('ssi', $cnam, $txt, $cid);
		$stmt->execute();
		
		if($stmt->affected_rows >0){
			echo '<meta http-equiv="refresh" content="0; url=secret.php" />';
			exit();
		}
		else {
			echo 'Could not change name of category '.$cid;
		}
	
}
	
	
	
if(empty($cid)){	
	$cid = filter_input(INPUT_GET, 'id_text', FILTER_VALIDATE_INT)
		or die('Missing/illegal categoryid parameter');
}
	
	require_once('db_con.php');
	$sql = 'SELECT headline, text_boks FROM text_table WHERE id_text=?';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('i', $cid);
	$stmt->execute();
	$stmt->bind_result($cnam, $txt);
	while($stmt->fetch()) {}
	
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
				<a href="#">OM KLINIKKEN</a>
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
    
	
<div class="poster">
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    	<p class="mig-tekst">OPDATER DIN ANMELDELSE</p><br>
    	<input class="login-boks" type="hidden" name="id_text" value="<?=$cid?>" />
    	<input class="login-boks" name="headline" type="text" value="<?=$cnam?>" placeholder="Categoryname" required />
    	<textarea class="login-boks" name="text_boks"><?=$txt?></textarea>
		<button class="knap" name="cmd" value="rename_category" type="submit">Opdater anmeldelse</button>
		<div class="klik"><a href="secret.php">Tilbage til opret anmeldelse</a></div>
	
</form>

<div class="container">

<?php 
		$sql = 'SELECT headline, name, text_boks FROM text_table';
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


<?php ob_flush(); ?>