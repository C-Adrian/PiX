<!DOCTYPE html>
<html lang="en">

<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="../css/style_loginAndRegister.css">
	<link rel="stylesheet" type="text/css" href="../css/style_global.css">
	<link rel="stylesheet" type="text/css" href="../css/style_errors.css">

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<div class="card">
		<h1>Register</h1>
		<form name="register" method="POST" action="../php/auth/auth.controller.php">
			<div class="nume">
				<label for="user">Username*</label>
				<input name="username" type="text" id="user" maxlength="32" placeholder="username">
			</div>
			<br>
			<div class="parola">
				<label for="passwd">Password*</label>
				<input name="password" type="password" id="passwd" maxlength="32" placeholder="password">
			</div>
			<br>
			<div class="parola">
				<label for="repasswd">Re-Password*</label>
				<input name="repassword" type="password" id="repasswd" maxlength="32" placeholder="password">
			</div>
			<?php
			if (isset($_COOKIE["emptyFields"])) {
				echo "<p class='loginErrors'>Trebuie completate toate campurile!</p>";
			}
			if (isset($_COOKIE["passNotMatching"])) {
				echo "<p class='loginErrors'>Campul 'Password' nu coresunde cu 'Re-Pasword!'</p>";
			}
			if (isset($_COOKIE["wrongCharInUsername"])) {
				echo "<p class='loginErrors'>Campul Username poate contine doar litere si cifre!</p>";
			}
			if (isset($_COOKIE["wrongCharInPassword"])) {
				echo "<p class='loginErrors'>Campul Password poate contine doar litere si cifre!</p>";
			}
			if (isset($_COOKIE["passToShort"])) {
				echo "<p class='loginErrors'>Campul Password trebuie sa contina minim 6 caractere!</p>";
			}
			if (isset($_COOKIE["usrNotAvailable"])) {
				echo "<p class='loginErrors'>Acest username este deja luat, incearca altceva!</p>";
			}
			?>

			<br>
			<button name="submit" value="register" type="submit"> Submit </button>

		</form>
		<br>
		<a href="login.html"> Inapoi la pagina de logare. </a>
	</div>


</body>

</html>