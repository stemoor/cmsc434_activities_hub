<?php

    require("../db/db_connect.php");
    require("../db/functions.php");

    sec_session_start();


    //make sure information was submitted
    if (isset($_POST["submit"])) {

        //retrieve information
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        //get prev url
        $from = $_SERVER['HTTP_REFERER'];

        //attempt to login
        if(login($email, $password, $db_connection)) {

            //login success
            //go back to previous page
            header('Location: '.$from);

        } else {

            //login failed
            //go back to previous page with an errorS
            header('Location: '.$from.'?error=1');
        }
    }

?>