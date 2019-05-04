<?php
include_once "../database.php";

function login($username, $password)
{
    echo $username, " ", $password;
    $connection = connectToDatabase();
    $getUsersStatement = $connection->prepare("SELECT * FROM users WHERE username = ? AND passw = ?");
    $getUsersStatement->bind_param("ss", $username, $password);
    $getUsersStatement->execute();
    $users = $getUsersStatement->get_result();
    if (mysqli_num_rows($users) == 1) {
        $_SESSION["username"] = $username;
        $_SESSION["success"] = "loggedIn";
        return true;
    } else {
        setcookie("usr_pswNotMatch", 1, time() + 1, "/");
        return false;
    }
}
function checkInputFields($username, $password, $repassword)
{
    if ($password == "" or $username == "" or $repassword == "") {
        setcookie("emptyFields", 1, time() + 1, "/");
        return false;
    } else {
        if (strcmp($password, $repassword) != 0) {
            setcookie("passNotMatching", 1, time() + 1, "/");
            return false;
        } else {
            if (strlen($password) < 6) {
                setcookie("passToShort", 1, time() + 1, "/");
                return false;
            } else {
                $validPass = preg_replace("/[a-zA-Z0-9]/", "", $password);
                $validUser = preg_replace("/[a-zA-Z0-9]/", "", $username);
                if ($validUser != "") {
                    setcookie("wrongCharInUsername", 1, time() + 1, "/");
                    return false;
                }
                if ($validPass != "") {
                    setcookie("wrongCharInPassword", 1, time() + 1, "/");
                    return false;
                }
            }
        }
    }
    return true;
}
function register($username, $password, $repassword)
{
    if (checkInputFields($username, $password, $repassword)) {
        $connection = connectToDatabase();
        $checkUser = $connection->prepare("SELECT username FROM users WHERE username = ?");
        $checkUser->bind_param("s", $username);
        $checkUser->execute();
        $dbResult = $checkUser->get_result();
        if (mysqli_num_rows($dbResult) > 0) {
            setcookie("usrNotAvailable", 1, time() + 1, "/");
            return false;
        } else {
            $_SESSION["username"] = $username;
            $_SESSION["success"] = "loggedIn";
            $getUsersID = $connection->prepare("SELECT id FROM users ORDER BY id DESC LIMIT 1");
            $getUsersID->execute();
            $dbResult = $getUsersID->get_result();
            $id = $dbResult->fetch_assoc();
            $id=$id["id"]+1;
            //file_put_contents("log.txt",$id);
            $insertStatement = $connection->prepare("INSERT INTO users VALUE(?, ?, ?)");
            $insertStatement->bind_param("iss", $id, $username, $password);
            $insertStatement->execute();
            //file_put_contents("log.txt",$connection->error);
            $insertStatement ->close();
            return true;
        }
    } else {
        return false;
    }
}

?>