<?php
session_start();
if (isset($_SESSION["username"])) :
	setcookie("filteredImg", 1, time(), "/");
	//setcookie("imageId", 1, time(), "/");
	include_once "../php/home/homeContent.php";
	deleteTempImage();
	?>


	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>PiX - Home</title>
		<meta name="description" content="PiX Home">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="../css/style_global.css">
		<link rel="stylesheet" href="../css/style_navbar.css">
		<link rel="stylesheet" href="../css/style_advancedSearchButton.css">
		<link rel="stylesheet" href="../css/style_home.css">
		<link rel="stylesheet" href="../css/style_errors.css">
		<script src="../JavaScript/script_global.js"></script>

	</head>

	<body>
		<nav id="navbar">
			<div id="navbar_half_left" class="navbar_half">
					<input type="text" placeholder="Search..." class="search_box">
					<form action="../php/home/search.controller.php" method="GET">
						<button name="simple_search_btn" type="submit" class="clickable_item" id="simple_search_button" value="simpleSearch">Go</button>
					</form>
					<button type="button" class="clickable_item" id="adv_search_1" onclick="hideAdvSearch()">Advanced
						search</button>
			</div>

			
			<div id="navbar_half_right" class="navbar_half">
				<a href="Upload.php" class="clickable_item">Upload </a>
				<a href="my_images.php" class="clickable_item">My images</a>
				<form action="../php/auth/auth.controller.php" method="POST">
					<button name="logout_btn" type="submit" class="clickable_item" value="logout">Logout</button>
				</form>

				<div class="dropdown_menu"> Menu
					<div class="dropdown_content">
						<button type="button" class="clickable_item" onclick="hideAdvSearch()">Advanced
								search</button>
						<a href="Upload.php" class="clickable_item">Upload </a>
						<a href="my_images.php" class="clickable_item">My images</a>
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
					<input id="size" placeholder="X MB" max="10" name="size">
				</div>
				<button id="btn_search" type="submit" name="search" value="advSearch">Go</button>
			</form>

		</aside>
		<main>
			<h3 class="image_display_label">Images</h3>
			<div id="image_display">
				<?php
				if (isset($_COOKIE["invalidSearch"])) {
					echo '<p id="invalidSearch"> Ai introdus o valoare gresita pentru dimensiune, sau nu ai introdus nimic! Mai incearca odata!<p>';
				} else {
					if (isset($_COOKIE["searchResult"])) {
						//display all images from json created in search.model.php
						$json = file_get_contents("../tempFiles/advSearchResults.json");
						unlink("../tempFiles/advSearchResults.json");
						$images = json_decode($json);
						foreach ($images as $image) {
							echo '
							<div class="image_frame">
								<h4 class="image_title">' . $image[1] . '</h4>
								<div class="image_object">
									<img src="' . $image[5] . '" alt="Not available" onclick="Redirect(' . $image[0] . ');">
									<button class="download_button">Download</button>
								</div>
								<p class="image_tags">' . $image[2] . '</p>
							</div>
							';
						}
					} else {
						$images = getAllImages();
						$keys = array_keys($images);
						foreach ($keys as $key) {
							echo '
						<div class="image_frame">
							<h4 class="image_title">' . $images[$key][1] . '</h4>
							<div class="image_object">
								<img src="' . $images[$key][0] . '" alt="Not available" onclick="Redirect(' . $key . ');">
								<button class="download_button">Download</button>
							</div>
							<p class="image_tags">' . $images[$key][2] . '</p>
						</div>
						';
						}
					}
				}
				?>
				<!--
							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/image1.jpg" alt="Not available" onclick="Redirect(2);">
									<button class="download_button">Download</button>
								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>

							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/abstract2.jpg" alt="Not available" onclick="Redirect();">
									<button class="download_button">Download</button>

								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>

							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/abstract.png" alt="Not available" onclick="Redirect();">
									<button class="download_button">Download</button>

								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>

							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/street.jpeg" alt="Not available" onclick="Redirect();">
									<button class="download_button">Download</button>

								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>

							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/vaporwave.jpg" alt="Not available" onclick="Redirect();">
									<button class="download_button">Download</button>

								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>

							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/field.png" alt="Not available" onclick="Redirect();">
									<button class="download_button">Download</button>

								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>

							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/lake.jpg" alt="Not available" onclick="Redirect();">
									<button class="download_button">Download</button>

								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>

							<div class="image_frame">
								<h4 class="image_title">Image name</h4>
								<div class="image_object">
									<img src="../Images/stub_images/tree.jpg" alt="Not available" onclick="Redirect();">
									<button class="download_button">Download</button>

								</div>
								<p class="image_tags">#tag #lorem #ipsum #sample</p>
							</div>
						-->
			</div>
		</main>

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