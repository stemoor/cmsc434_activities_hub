<?php

    require("../db/db_connect.php");
    require("../db/functions.php");

    sec_session_start();

    //make sure information was submitted
    if (isset($_POST["signup-submit"])) {

        //retrieve information
        $firstname = trim($_POST["firstname"]);
        $lastname = trim($_POST["lastname"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        //check if user alredy in the system
        if(checkUserExists($db_connection, $email)){

            //get prev url
            $from = $_SERVER['HTTP_REFERER'];
            //signup failed
            header('Location:'.$from.'?error=2');
        } else {

        }

    }

?>