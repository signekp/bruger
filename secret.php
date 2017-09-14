<?php
	session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Hemmelig side</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
	<nav>
		<div class="wrapper">
			
			<div class="login">
				<?php

				
					if(isset($_SESSION['u_id'])) {
						echo '<form action="includes/logout.inc.php" method="POST">
							<button type="submit" name="submit">Log out</button>
							</form>';
					} else {
						echo '<form action="includes/login.inc.php" method="POST">
							<input type="text" name="uid" placeholder="Username/email">
							<input type="password" name="pwd" placeholder="password">
							<button type="submit" name="submit">Log in</button>
							</form>
							<a href="signup.php">Sign up</a>';
					}
?>
			
<?php
				
				
				$id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
			
				
				
				
				
				
				
				if($cmd = filter_input(INPUT_POST, 'cmd')) {
					if ($cmd == 'opret_note') {
						$overskrift = filter_input(INPUT_POST, 'overskrift')
							or die('missing overskrift');
						$navn = filter_input(INPUT_POST, 'navn')
							or die('missing overskrift');
						$tekst = filter_input(INPUT_POST, 'tekst')
							or die('missing overskrift');
						$id = filter_input(INPUT_POST, 'user_id')
							or die('missing overskrift');
						
						require_once(dbh.inc.php);
						$sql = 'INSERT INTO postit (overskrift, navn, tekst, users_user_id) VALUES (?, ?, ?, ?)';
						$stmt = $conn -> prepare($sql);
						$stmt -> bind_param('sssi', $overskrift, $navn, $tekst, $id);
						$stmt -> execute();
						
						if ($stmt->affected_rows > 0) {
							echo '<meta http-equiv="refresh" content="0; url=secret.php?user_id=' . $id . '" />';
							} 
						else {
							echo $stmt->error;
						}
					}
				}
				
				
?>


<section class="main-container">
	<div class="main-wrapper">
		<h2>Dine noter</h2>
		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="overskrift" placeholder="overskrift">
			<input type="text" name="navn" placeholder="navn">
			<input type="text" name="tekst" placeholder="tekst">
			<input type="hidden" name="user_id" value="<?=$id?>">
			<button type="submit" name="cmd" value="opret_note">Post</button>
		</form>
	</div>
</section>


</body>
</html>