<?php
include_once "../database.php";
function upload($fisier_ales,$fisiere_alese,$tag1,$tag2,$tag3,$tag4,$tag5,$titlu,$descriere)
{
    if($fisier_ales[name]==NULL and $fisiere_alese[name]==NULL)
    {
        setcookie("NoImage", 1, time() + 1, "/");
        return false;
    }
    
    if($tag1==NULL)
    {   
        setcookie("NoTag1", 1, time() + 1, "/");
        return false;
    }
    if($titlu==NULL)
    {
        setcookie("NoTitle", 1, time() + 1, "/");
        return false;
    }

    if($descriere==NULL)
    {
        setcookie("NoDescriere", 1, time() + 1, "/");
        return false;
    }
    if($fisier_ales[name]!=NULL)
    {
        
        $ext = pathinfo($fisier_ales[name], PATHINFO_EXTENSION);
        $data=date(DATE_RFC2822);
        if($tag1[0]!='#')
        $tags='#'.$tag1;
        else
        $tags=$tag1;
        if($tag2)
        {
            if($tag2[0]!='#')
            $tags=$tags.' #'.$tag2;
            else
            $tags=$tags.' '.$tag2;
        }
        if($tag3)
        {
            if($tag3[0]!='#')
            $tags=$tags.' #'.$tag3;
            else
            $tags=$tags.' '.$tag3;
        }
        if($tag4)
        {
            if($tag4[0]!='#')
            $tags=$tags.' #'.$tag4;
            else
            $tags=$tags.' '.$tag4;

        }
        if($tag5)
        {
            if($tag5[0]!='#')
            $tags=$tags.' #'.$tag5;
            else
            $tags=$tags.' '.$tag5;

        }
        $size=$fisier_ales[size];
        
        
        $connection = connectToDatabase();
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
        

        move_uploaded_file($fisier_ales['tmp_name'],'../../Images/DataBaseImages/'.$ImgId.'.'.$ext);
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
    else
    {

    }
    return true;
}

?>