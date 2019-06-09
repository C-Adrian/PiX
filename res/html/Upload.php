
<?php
session_start();
if (isset($_SESSION["username"])) :
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Upload</title>
	<link rel="stylesheet" type="text/css" href="../css/style_upload.css">
	<link rel="stylesheet" type="text/css" href="../css/style_global.css">
	<link rel="stylesheet" type="text/css" href="../css/style_home.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	
	
</head>

<body>
	<nav id="navbar">
		<div id="navbar_half_right" class="navbar_half">
			<a href="Home.php" class="clickable_item">Home</a>
			<form action="../php/auth/auth.controller.php" method="POST">
				<button name="logout_btn" type="submit" class="clickable_item" id="logout_button_1" value="logout">Logout</button>
			</form>
		</div>
	</nav>
	</form>
    <form name="incarca" method="POST" enctype="multipart/form-data" action="../php/upload/upload.controller.php">
	<main class="card">
		<div class="informatii" id="informatii">
       
			
			<?php
		if (isset($_COOKIE['NoImage'])) {
			echo '<p style="color: red"> * Nici o imagine aleasa! </p>';
		}
		?>

			<label for="fisiere">Alege o imagine sau mai multe imagini</label>
			<input type="file" multiple="multiple" name="imagini_alese[]" id="fisiere">
		<div class="completare" id="completare"></div>
			<?php
		if (isset($_COOKIE['NoTag1'])) {
			echo '<p style="color: red"> * Tag1 e obligatoriu! </p>';
		}
		?>
			
			
			
			<?php
		if (isset($_COOKIE['NoTitle'])) {
			echo '<p style="color: red"> * Pune un titlu! </p>';
		}
		?>
			
			<?php
		if (isset($_COOKIE['NoDescriere'])) {
			echo '<p style="color: red"> * Pune o descriere! </p>';
		}
		?>
			
            
          
        

		</div>
        
		<div class="imagine" id="imagine">
            
			<img src="../Images/stub_images/dota.jpg" alt="o imagine">
		</div>
        
	</main>
    </form>
	<script  src="../JavaScript/Upload.js"></script>
</body>

</html>
<?php
else :
?>
	<!DOCTYPE html>
	<html lang="ro">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/style_errors.css" />
	</head>
	<body class="notLogged">
		<p id="notLogged">
			Nu esti logat, intai logheaza-te!!! <p><br>
	</body>
	</html>
<?php
endif;
?>