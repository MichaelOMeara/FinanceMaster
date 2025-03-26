<?php
    // require "DBConnect.php
    $fname = $_GET["fname"];
    $lname = $_GET["lname"];
    
    $pswd = $_GET["pswd"];
    $pswd2 = $_GET["pswd2"];
    $usertype ="customer";
    $name = $fname. " " . $lname;
    
    if($pswd == $pswd2){
        $Password = $pswd;
    }
    
    
    /*
    $sql = "insert into users values (0, '".$name. "', '"
            . $email . "', '" $Password . "', '" $usertype"')";
     echo modifyDB($sql).
             */
     
?>

