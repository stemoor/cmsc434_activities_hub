<?php

    require("../db/db_connect.php");
    require("../db/functions.php");

    sec_session_start();
    
    //make sure information was submitted
    if (isset($_POST["submit"])) {

        //retrieve information
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        //attempt to login
        if(login($email, $password, $db_connection)) {

            //login success
            header('Location: ../../index.php');

        } else {
            //login failed
            header('Location: ../../index.php?error=1');
        }
    }

?>