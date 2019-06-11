<?php
session_start();
if (isset($_SESSION["username"])) :
    include_once("../php/edit/displayDinamicContent.php");
    if (isset($_COOKIE["init"])) {
        editInit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../css/style_editAndView.css">
        <link rel="stylesheet" href="../css/style_global.css">
        <link rel="stylesheet" href="../css/style_home.css">
        <link rel="stylesheet" href="../css/style_errors.css">
        <title>Edit And View</title>
        <script src="../JavaScript/script_global.js"></script>
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
        <main>
            <div class="edit_view">
                <header>
                    <aside id="left">
                        <?php
                        $image = getImage($_COOKIE["imageId"]);
                        echo '<h2>' . $image[0] . '</h2>';
                        echo '<p>' . $image[1] . '</p>';
                        echo '<img id="selected_image" src=' . $image[2] . ' alt="image1">';
                        ?>
                    </aside>
                    <?php
                    $imagePath = getImagePath($_COOKIE["imageId"]);
                    $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $negativeF = "../Images/temp/" . $_SESSION["username"] . "/negative" . $_COOKIE["imageId"] . "." . $ext;
                    $grayscaleF = "../Images/temp/" . $_SESSION["username"] . "/grayscale" . $_COOKIE["imageId"] . "." . $ext;
                    $embossF = "../Images/temp/" . $_SESSION["username"] . "/emboss" . $_COOKIE["imageId"] . "." . $ext;
                    $meanF = "../Images/temp/" . $_SESSION["username"] . "/mean" . $_COOKIE["imageId"] . "." . $ext;
                    //$original = "../Images/temp/" . $_SESSION["username"] . "/temp" . $_COOKIE["imageId"] . "." . $ext;
                    ?>
                    <aside id="right">
                        <h4>Aplica un filtru:</h4>
                        <form name="filter_image" action="../php/edit/edit.controller.php" method="GET">
                            <div class="filters">
                                <div class="filter">
                                    <?php
                                    echo '<img src="' . $negativeF . '" alt="IMG_FILTER_NEGATE">'
                                    ?>
                                    <input class="filterCBX" onclick="checkOnlyOne(this.value);" id="IMG_FILTER_NEGATE" type="checkbox" name="filter" value="IMG_FILTER_NEGATE">
                                    <label for="IMG_FILTER_NEGATE">Negate Filter</label>
                                </div>
                                <div class="filter">
                                    <?php
                                    echo '<img src="' . $grayscaleF . '" alt="IMG_FILTER_NEGATE">'
                                    ?>
                                    <input class="filterCBX" onclick="checkOnlyOne(this.value);" id="IMG_FILTER_GRAYSCALE" type="checkbox" name="filter" value="IMG_FILTER_GRAYSCALE">
                                    <label for="IMG_FILTER_GRAYSCALE">Grayscale Filter</label>
                                </div>
                                <div class="filter">
                                    <?php
                                    echo '<img src="' . $embossF . '" alt="IMG_FILTER_NEGATE">'
                                    ?>
                                    <input class="filterCBX" onclick="checkOnlyOne(this.value);" id="IMG_FILTER_EMBOSS" type="checkbox" name="filter" value="IMG_FILTER_EMBOSS">
                                    <label for="IMG_FILTER_EMBOSS">Emboss Filter</label>
                                </div>
                                <div class="filter">
                                    <?php
                                    echo '<img src="' . $meanF . '" alt="IMG_FILTER_NEGATE">'
                                    ?>
                                    <input class="filterCBX" onclick="checkOnlyOne(this.value);" id="IMG_FILTER_MEAN_REMOVAL" type="checkbox" name="filter" value="IMG_FILTER_MEAN_REMOVAL">
                                    <label for="IMG_FILTER_MEAN_REMOVAL">Mean Remove Filter</label>
                                </div>
                                <div class="filter">
                                    <?php
                                    echo '<img src="' . $imagePath . '" alt="IMG_FILTER_NEGATE">'
                                    ?>
                                    <input class="filterCBX" onclick="checkOnlyOne(this.value);" id="no_filter" type="checkbox" name="filter" value="no_filter">
                                    <label for="no_filter">No Filter</label>
                                </div>
                            </div>
                            <button name="submit" value="filter" class="button_item" type="submit">Alege filtrul</button>
                        </form>
                    </aside>

                </header>

                <footer>
                    <div class="tags">
                        <h4>Tags: </h4>
                        <ul>
                            <?php
                            $tags = $image[3];
                            foreach ($tags as $tag) {
                                echo '<li class="tag">' . $tag . '</li>';
                                echo " ";
                            }
                            ?>
                        </ul>
                    </div>
                    <div>
                        <form id="download_form" action="../php/edit/edit.controller.php" method="GET">
                            <button name="submit" value="download" class="footer_btn" type="submit">Salveaza ca:</button>
                            <select class="save_dropdown" name="download">
                                <option value="jpeg">JPEG</option>
                                <option value="bmp">BMP</option>
                                <option value="png">PNG</option>
                            </select>
                        </form>
                        <?php
                        $bool = checkDelBtn();
                        if ($bool) {
                            echo '
                                    <form id="delete_form" action="../php/edit/edit.controller.php" method="POST">
                                        <button name="submit" value="delete" class="footer_btn">Sterge imaginea</button>
                                    </form>
                                    ';
                        }
                        ?>
                        <form id="rotate_form" action="../php/edit/edit.controller.php" method="GET">
                            <button class="footer_btn" type="submit" name="direction" value="left">Roteste stanga</button>
                            <button class="footer_btn" type="submit" name="direction" value="right">Roteste dreapta</button>
                        </form>
                    </div>
                    <form id="resize_form" action="../php/edit/edit.controller.php" method="GET">
                        <div>
                            <div>
                                <label for="width">Selecteaza latimea in pixeli:</label>
                                <input type="number" id="width" name="Width" placeholder="X px">
                            </div>
                            <div>
                                <label for="height">Selecteaza inaltimea in pixeli:</label>
                                <input type="number" id="height" name="Height" placeholder="X px">
                            </div>
                        </div>
                        <?php
                        if (isset($_COOKIE['wrongDimension'])) {
                            echo '<p id="wrongDimension"> Nu ai completat ambele campuri cu dimensiuni!<p>';
                        }
                        ?>
                        <button name="submit" value="resize" class="footer_btn" type="submit">Redimensioneaza</button>
                    </form>
                </footer>

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