<?php
    function connectToDatabase()
    {
        $dbUser="root";
        $dbPass="";
        $dbName="pix_db";
        $connection=new mysqli("localhost",$dbUser,$dbPass,$dbName) or die("Unabele to connect to database $dbName");
        return $connection;
    }
?>