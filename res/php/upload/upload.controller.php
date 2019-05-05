<?php
session_start();
include_once "upload.model.php";

if ($_POST["submit"] == "Incarca")
{
        
        $resultat_imagine=upload($_FILES["imagine_aleasa"],$_FILES["imagini_alese"],$_POST["Tag1"],$_POST["Tag2"],$_POST["Tag3"],$_POST["Tag4"],$_POST["Tag5"],$_POST["Titlu"],$_POST["Descriere"]);
        
        
        if($resultat_imagine)
            header("location: ../../html/home.php");
            else
            header("location: ../../html/Upload.php");
    }


?>