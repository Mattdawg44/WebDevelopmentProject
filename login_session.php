<?php

include "sanitization.php";
include "connection.php";


if (isset($_POST['name']) && isset($_POST['password'])) {
    $username = sanitizeMYSQL($_POST['name']);
    $password= md5(sanitizeMYSQL($_POST['password']));
    
    $query = "SELECT * FROM customer WHERE ID='".$username."' AND Password='".$password."'";
    $result = mysql_query($query);
    $text="";
    if (!$result)
        $text="Invalid username or password";
    else{
        $row_count = mysql_num_rows($result);
    if($row_count==1){ 
       $text="success";
       $row = mysql_fetch_array($result);
       session_start();
       ini_set('session.gc_maxlifetime',60*10); //the life time of the session is 10 minutes
        $_SESSION["username"] =$row["ID"];
    }
    else
        $text="Invalid username or password"; 
    }
    echo $text;
}
