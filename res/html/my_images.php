<?php
session_start();
if (isset($_SESSION["username"])) :
	setcookie("filteredImg", 1, time(), "/");
	include_once "../php/home/homeContent.php";
	?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<?php
		echo "<title>".$_SESSION["username"]."'s images</title>"
		?>
		<meta name="description" content="PiX Home">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="../css/style_global.css">
		<link rel="stylesheet" href="../css/style_navbar.css">
		<link rel="stylesheet" href="../css/style_advancedSearchButton.css">
		<link rel="stylesheet" href="../css/style_home.css">
		<script src="../JavaScript/script_global.js"></script>

	</head>

	<body>
		<nav id="navbar">
			<div id="navbar_half_left" class="navbar_half">
					<input type="text" placeholder="Search..." class="search_box" id="search_box">
					<button type="button" class="clickable_item" id="simple_search_button" >Go</button>
					<button type="button" class="clickable_item" id="adv_search_1"">Advanced
						search</button>
			</div>

			<div id="navbar_half_right" class="navbar_half">
				<a href="Upload.html" class="clickable_item">Upload </a>
				<a href="home.html" class="clickable_item">Home</a>
				<form action="../php/auth/auth.controller.php" method="POST">
					<button name="logout_btn" type="submit" class="clickable_item" value="logout">Logout</button>
				</form>

				<div class="dropdown_menu"> Menu
					<div class="dropdown_content">
						<button type="button" class="clickable_item" id="adv_search_2">Advanced
								search</button>
						<a href="Upload.html" class="clickable_item">Upload </a>
						<a href="home.html" class="clickable_item">Home</a>
						<form action="../php/auth/auth.controller.php" method="POST">
							<button name="logout_btn" type="submit" class="clickable_item" value="logout">Logout</button>
						</form>
					</div>
				</div>
			</div>
		</nav>

		<aside class="advanced_search">
			<h2>Advanced Search</h2>
			<form action="../php/home/search.controller.php" method="GET">
				<div>
					<label for="tags_search">Tags:</label>
					<input type="text" name="tags_list" id="tags_search" placeholder="Add tags...">
				</div>
				<div>
					<p class="section_title">Creation date:</p>
					<div>
						<label for="start_date">No older than</label>
						<input type="date" id="start_date" name="sDate" min="1970-01-01">
					</div>
					<div>
						<label for="end_date">No newer than</label>
						<input type="date" id="end_date" name="eDate">
					</div>
				</div>
				<div id="dimension_section">
					<p class="section_title">Dimension:</p>
					<div id="min_width_div">
						<label for="min_width">Min width</label>
						<input id="min_width" type="number" placeholder="X px" min="0" max="4000" name="minwidth">
					</div>
					<div id="max_width_div">
						<label for="max_width">Max width</label>
						<input id="max_width" type="number" placeholder="X px" min="0" max="4000" name="maxwidth">
					</div>
					<div id="min_height_div">
						<label for="min_height">Min height</label>
						<input id="min_height" type="number" placeholder="X px" min="0" max="3000" name="minheight">
					</div>
					<div id="max_height_div">
						<label for="max_height">Max height</label>
						<input id="max_height" type="number" placeholder="X px" min="0" max="3000" name="maxheight">
					</div>
				</div>
				<p class="section_title">Size*:</p>
				<div>
					<label for="size">Maximum Size</label>
					<input id="size" placeholder="X MB" type="number" step="0.0001" min="0" max="10" name="size">
				</div>
				<button id="btn_search" type="button" name="search">Go</button>
			</form>
		</aside>

		<main id="main">
			<h3 class="image_display_label">My images</h3>

			<div id="image_display"></div>

		</main>

	</body>

	<script src="../JavaScript/script_global.js"></script>
	<script src="../JavaScript/query-request_build.js"></script>
	<script src="../JavaScript/image_fetch-display.js"></script>
	<script src="../JavaScript/my_images_controller.js"></script>

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