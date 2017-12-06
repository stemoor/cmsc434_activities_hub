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
        $avatar =  $_POST['avatar-file'];
        $is_planner =false;

        //check if user alredy in the system
        if(checkUserExists($db_connection, $email)){

            //get prev url
            $from = $_SERVER['HTTP_REFERER'];
            //signup failed
            header('Location:'.$from.'?error=2');

        }

        $organization;
        $phone1;
        $phone2;
        $phone3;
        $phone4;
        $website;

        //check if user wants to be a planner
        if(isset($_POST["planner"])){

            $is_planner = true;

            $organization = trim($_POST["organization"]);

            $phone1 = $_POST["country_code"];
            $phone2 = $_POST["number_1"];
            $phone3 = $_POST["number_2"];
            $phone4 = $_POST["number_3"];
            $website = trim($_POST["website"]);
        }

        //add user to db
        if(insert_user($db_connection, $firstname, $lastname, $email, $password, $avatar, $is_planner)){
            echo "user inserted";

            $phone_number = "+".$phone1." ".$phone2." - ".$phone3." - ".$phone4;

            //get the new user id
            $data = fetch_user_by_email($db_connection, $email);
            $id = $data != null ? $data['id'] : -1;

            //insert user on planner if planner option choosen
            if($id !== -1 && insert_planner($db_connection, $id, $organization, $phone_number, $website)) {
                echo "planner inserted";
                //get browser info
                $user_browser = $_SERVER['HTTP_USER_AGENT'];

                //save login info in session
                $_SESSION['email'] = $email;
                $_SESSION['user_name'] = $data['first_name'];
                $_SESSION['user_id'] = $id['id'];
                $_SESSION['login_string'] = hash('sha256', $data['password'].$user_browser);
                $_SESSION['seed'] = $user_browser;
                $_SESSION['is_planner'] = $data['is_planner'];

                //get prev url
                $from = $_SERVER['HTTP_REFERER'];
                //go back to previous page
                header('Location:'.$from);
            }
        }

        //something went wrong :)
        $from = $_SERVER['HTTP_REFERER'];

        //signup failed
        header('Location:'.$from.'?error=3');

    }

?>