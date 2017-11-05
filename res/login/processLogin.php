<?php

    require("../db/dbLogin.php");

    if (isset($_POST["submit"])) {

        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        //connect to db
        $db_connection = connectToDB();

        //query to find user by username
        $query ="select * from $users_table where email=\"$email\"";

        //send out query
        $result = $db_connection->query($query);

         echo "<h1>query sent</h1> ".$email."<br>";

        //check result from query
        if(!$result) {

            //something went wrong with the requrest
            die("Search Failed: ".$db_connection->error);

        } else {

                //request went through, check the results
                $num_rows = $result->num_rows;

                //if result is empty, no entry in table that match email input
                if ($num_rows === 0) {
                    echo "not email - failed";
                } else {
                    //found match, must check if password matches

                }
        }

    }

?>