<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "connection.php";
include "sanitization.php";
session_start();

if (isset($_POST['type']) && is_session_active()) {

    $type = sanitizeMYSQL($_POST['type']);

    switch ($type) {
        case "logout":
            logout();
            echo "success";
            break;
    }
}

function is_session_active() {
    return isset($_SESSION) && count($_SESSION) > 0;
    //check if it has been one minute since the start of the session. 
}

//a function for deleting the session is already available
function logout(){
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
?>