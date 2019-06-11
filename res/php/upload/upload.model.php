<?php
include_once "../database.php";
function upload($fisiere_alese,$tag1,$titlu,$descriere,$i)
{
    
    $connection = connectToDatabase();

        if($fisiere_alese['name'][0]!=NULL)
    {
        $total = count($fisiere_alese['name']);
        
        $ext = pathinfo($fisiere_alese['name'][$i], PATHINFO_EXTENSION);
        $data=date(DATE_RFC2822);
        $tags="";
        $tg_uri=explode(" ",$tag1);
        foreach($tg_uri as $tg)
        {
            if($tg[0]!='#')
            {
                if($tags=="")
                    $tags=$tags.'#'.$tg;
                else
                    $tags=$tags.' #'.$tg;
            }
            else
            {
                if($tags=="")
                    $tags=$tags.$tg;
                else
                    $tags=$tags.' '.$tg;
            }
        }

        $size=$fisiere_alese['size'][$i];
        
        
        
        $checkID = $connection->prepare("SELECT id FROM users WHERE username = ?");
        $checkID->bind_param("s", $_SESSION["username"] );
        $checkID->execute();
        $userID = $checkID->get_result();
        $col1 = $userID->fetch_assoc();
        $checkID -> close();
        $userID=(string)$col1['id'];
        $checkImgID = $connection->prepare("SELECT * FROM images where id= (SELECT MAX(id) from images)");
        $checkImgID ->execute();
        $ImgId= $checkImgID->get_result();
        $col2=$ImgId->fetch_assoc();
        $checkImgID->close();
        $ImgId=(string)((int)$col2['id']+1);
        
        if($ext=='jpg' or $ext=='png' or $ext=='bmp' )
        move_uploaded_file($fisiere_alese['tmp_name'][$i],'../../Images/DataBaseImages/'.$ImgId.'.'.$ext);
        else{
            $ext='png';
            $im=imagecreatefromstring(file_get_contents($fisiere_alese['tmp_name'][$i]));
            imagepng($im,'../../Images/DataBaseImages/'.$ImgId.'.'.$ext);
            }
        list($width, $height, $t, $attr) = getimagesize('../../Images/DataBaseImages/'.$ImgId.'.'.$ext);
        $dimensiune=(string)$width."x".(string)$height; 
        $localpath='../../Images/DataBaseImages/'.$ImgId.'.'.$ext;
        $localpath=(string)$localpath;
        $localpath=substr($localpath,3);

        $insertStatement= $connection->prepare("INSERT INTO images VALUES(?,?,?)");
        $insertStatement -> bind_param("sss", $ImgId ,$userID ,$localpath);
        $insertStatement -> execute();
        $insertStatement -> close();
        
        $insertStatement = $connection -> prepare("INSERT INTO exifinfo VALUES(?, ?, ?, ?, ?, ?, ?)");
        $insertStatement -> bind_param("sssssss", $ImgId ,$data,$dimensiune,$size,$titlu,$descriere,$tags);
        $insertStatement -> execute();
        $insertStatement -> close();
            
        
        

    }
    return true;
}

?>