<?php

    require("../db/db_connect.php");
    require("../db/functions.php");

    //make sure information was submitted
    if (isset($_POST["submit"])) {

        //retrieve information
        $firstname = trim($_POST["firstname"]);
        $lastname = trim($_POST["lastname"]);
        $password = trim($_POST["password"]);
        $re_password = trim($_POST["re-password"]);

        //todo 
    }

?>