<?php
session_start();
include_once "upload.model.php";

/*echo($_FILES["imagini_alese"]['tmp_name'][0]);
$im=imagecreatefromstring(file_get_contents($_FILES["imagini_alese"]['tmp_name'][0]));
imagepng($im,'output.png');
*/

if ($_POST["submit"] == "Incarca")
    for( $i=0 ; $i < count($_FILES["imagini_alese"]['name']) ; $i++ )
    {
   
        $resultat_imagine=upload($_FILES["imagini_alese"],$_POST["Tag".($i+1).""],$_POST["Titlu".($i+1).""],$_POST["Descriere".($i+1).""],$i);
        if($resultat_imagine)
                header("location: ../../html/home.php");
                else
                header("location: ../../html/Upload.php");
    }



?>