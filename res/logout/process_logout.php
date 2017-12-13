<?php

    require("../db/db_connect.php");
    require("../db/functions.php");

    sec_session_start();


    //make sure information was submitted
    if (isset($_POST["logout"])) {

        //log out
        logout($db_connection );

            //get prev url
            $from = $_SERVER['HTTP_REFERER'];

            //return to prev url
            header('Location: ../../index.php');

    }

?>