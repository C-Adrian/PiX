
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
			<a href="Home.html" class="clickable_item">Home</a>
			<a href="./Login.html" class="clickable_item">Logout</a>
		</div>
	</nav>
    <form name="incarca" method="POST" enctype="multipart/form-data" action="../php/upload/upload.controller.php">
	<main class="card">
		<div class="informatii">
       
			<label for="fisier">Alege o imagine.
			</label>
			<input type="file" name="imagine_aleasa" id="fisier">
			<?php
		if (isset($_COOKIE['NoImage'])) {
			echo '<p style="color: red"> * Nici o imagine aleasa! </p>';
		}
		?>

			<label for="fisiere">Sau mai multe imagini</label>
			<input type="file" multiple="multiple" name="imagini_alese" id="fisiere">


			<?php
		if (isset($_COOKIE['NoTag1'])) {
			echo '<p style="color: red"> * Tag1 e obligatoriu! </p>';
		}
		?>
			<label for="tag1" >Tag1</label>
			<input type="text" name="Tag1" id="tag1">
			<label for="tag2">Tag2</label>
			<input type="text" name="Tag2" id="tag2">
			<label for="tag3">Tag3</label>
			<input type="text" name="Tag3" id="tag3">
			<label for="tag4">Tag4</label>
			<input type="text" name="Tag4" id="tag4">
			<label for="tag5">Tag5</label>
			<input type="text" name="Tag5" id="tag5">

			<?php
		if (isset($_COOKIE['NoTitle'])) {
			echo '<p style="color: red"> * Pune un titlu! </p>';
		}
		?>
			<label for="titlu">Titlu</label>
			<input type="text" name="Titlu" id="titlu" maxlength="10" placeholder="titlu">
			<?php
		if (isset($_COOKIE['NoDescriere'])) {
			echo '<p style="color: red"> * Pune o descriere! </p>';
		}
		?>
			<label for="Descriere">Descriere</label>
			<textarea rows="4" cols="50" id="Desc" name="Descriere" maxlength="400"></textarea>
            <label for="Incarca">Incarca</label>
            <button name="submit" value="Incarca" type="submit"> Incarca </button>
          
        

		</div>
        
		<div class="imagine">
            
			<img src="../Images/stub_images/dota.jpg" alt="o imagine">
		</div>
        
	</main>
    </form>

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