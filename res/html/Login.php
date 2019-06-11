<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="../css/style_loginAndRegister.css">
	<link rel="stylesheet" type="text/css" href="../css/style_global.css">
	<link rel="stylesheet" type="text/css" href="../css/style_errors.css">

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
	<div class="card">
		<h1>Login</h1>
		<form name="login" method="POST" action="../php/auth/auth.controller.php">
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
			<button name="submit" value="login" type="submit"> Submit </button>
		</form>
		<?php
		if (isset($_COOKIE['usr_pswNotMatch'])) {
			echo '<p id="usr_pswNotMatch"> Combinatie parola, username incorecta!<p>';
		}
		?>
		<br>
		<a href="Register.html"> Apasati aici pentru a crea un cont nou! </a>

	</div>

</body>

</html>