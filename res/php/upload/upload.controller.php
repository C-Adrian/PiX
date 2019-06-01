<?php
session_start();
include_once "upload.model.php";

for( $i=0 ; $i < count($_FILES["imagini_alese"]['name']) ; $i++ )
{
   
    $resultat_imagine=upload($_FILES["imagini_alese"],$_POST["Tag".($i+1).""],$_POST["Titlu".($i+1).""],$_POST["Descriere".($i+1).""],$i);
    if($resultat_imagine)
            header("location: ../../html/home.php");
            else
            header("location: ../../html/Upload.php");
}
/*if ($_POST["submit"] == "Incarca")
{
        
        $resultat_imagine=upload($_FILES["imagini_alese"],$_POST["Tag1"],$_POST["Titlu"],$_POST["Descriere"]);
        
        if($resultat_imagine)
            header("location: ../../html/home.php");
            else
            header("location: ../../html/Upload.php");
}*/


?>