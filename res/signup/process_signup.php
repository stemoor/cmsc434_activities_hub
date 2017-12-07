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
        $avatar_img_content = null;
        $is_planner = false;


        //check planner status
        if(isset($_POST["planner"])){

            $is_planner = true;

        }

        //image is optional so check if uploaded
        if(isset($_FILES["avatar"])){
            $avatar_file_name = $_FILES["avatar"]["tmp_name"];
            $avatar_img_content = addslashes(file_get_contents($avatar_file_name));

        }


        //check if user alredy in the system, if so return to prev page with an error
        if(checkUserExists($db_connection, $email)){

            //get prev url
            $from = $_SERVER['HTTP_REFERER'];
            //signup failed
            header('Location:'.$from.'?error=2');

        }

        //attempt to add user to db
        if(insert_user($db_connection, $firstname, $lastname, $email, $password, $avatar_img_content, $is_planner)){

            //insertion successfull

            //get the new user id
            $data = fetch_user_by_email($db_connection, $email);
            $id = $data != null ? $data['id'] : -1;


            //insert user on planner table as well if planner option choosen
            if($is_planner){
                echo "insert user";
                //retrieve organization information
                $organization = trim($_POST["organization"]);

                $phone1 = $_POST["country_code"];
                $phone2 = $_POST["number_1"];
                $phone3 = $_POST["number_2"];
                $phone4 = $_POST["number_3"];
                $website = trim($_POST["website"]);

                $phone_number = "+".$phone1." ".$phone2." - ".$phone3." - ".$phone4;

                if($id !== -1 && insert_planner($db_connection, $id, $organization, $phone_number, $website)){


                    //save login info in session
                    $_SESSION['user_name'] = $organization;


                } else {

                    //something went wrong :)
                    $from = $_SERVER['HTTP_REFERER'];

                    //signup failed
                    header('Location:'.$from.'?error=3');

                }
            }

            //get browser info for seed
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            //save login info in session
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['user_name'] = $data['first_name'];
            $_SESSION['login_string'] = hash('sha256', $data['password'].$user_browser);
            $_SESSION['seed'] = $user_browser;
            $_SESSION['is_planner'] = $is_planner;

            //all insertions successfull
            //get prev url
            $from = $_SERVER['HTTP_REFERER'];

            //go back to previous page
            header('Location:'.$from);

        } else {

            //something went wrong :)
            $from = $_SERVER['HTTP_REFERER'];

            //signup failed
            header('Location:'.$from.'?error=3');
        }
    }

?>