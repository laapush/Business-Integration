<?php 

include 'config.php';

//Fehlerberichterstattung
error_reporting(0);

//Sessionaufbau
session_start();

//Sessionüberprüfung
if (isset($_SESSION['vname'])) {
    header("Location: login.php");
}

//Registrierung
if (isset($_POST['submit'])) {
	$vname = $_POST['vname'];
	$nname = $_POST['nname'];
	$ssn = $_POST['ssn'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	//Daten in die Datenbank eintragen
	if ($password == $cpassword) {
		$sql = "SELECT * FROM user WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
		if (!$result->num_rows > 0) {
			$sql = "INSERT INTO user (vname, nname, ssn, email, password)
					VALUES ('$vname','$nname', '$ssn', '$email', '$password')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				echo "<script>alert('Registrierung wurde abgeschlossen.')</script>";
				$vname = "";
				$nname = "";
				$ssn = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			} else {
				echo "<script>alert('Passwort wurde falsch eingegeben!')</script>";
			}
		} else {
			echo "<script>alert('Die E-Mail-Adresse existriert bereits.')</script>";
		}
		
	} else {
		echo "<script>alert('Die Passwörter stimmen nicht überein.')</script>";
	}
}

?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
			<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
			<link rel="stylesheet" type="text/css" href="style.css">
			<title>Registrierung</title>
		</head>
		<body>
			<div class="container">
			
			<!--Formular für Registrierung-->
				<form action="" method="POST" class="login-email">
					<p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>

					<div class="input-group">
						<input type="text" placeholder="Vorname" name="vname" value="<?php echo $vname; ?>" required>
					</div>
					<div class="input-group">
						<input type="text" placeholder="Nachname" name="nname" value="<?php echo $nname; ?>" required>
					</div>
					<div class="input-group">
						<input type="ssn" placeholder="SSN " name="ssn" value="<?php echo $ssn; ?>" required>
					</div>
					<div class="input-group">
						<input type="email" placeholder="E-Mail-Adresse" name="email" value="<?php echo $email; ?>" required>
					</div>
					<div class="input-group">
						<input type="password" placeholder="Passwort" name="password" value="<?php echo $_POST['password']; ?>" required>
					</div>
					<div class="input-group">
						<input type="password" placeholder="Passwort wiederholen" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
					</div>
					<div class="input-group">
						<button name="submit" class="btn">Registrieren</button>
					</div>

					<p class="login-register-text">Bereits registriert?<a href="login.php"> Jetzt anmelden</a>.</p>
				</form>
			</div>
		</body>
	</html>