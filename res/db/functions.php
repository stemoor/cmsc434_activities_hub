<?php

    function sec_session_start() {
        $session_name = "activities_hub";
        $secure = FALSE;

        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }

        //get current cookie params
        $cookie_params = session_get_cookie_params();

        session_set_cookie_params($cookie_params["lifetime"], $cookie_params["path"], $cookie_params["domain"], $secure, $httponly);

        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session
        session_regenerate_id();    // regenerated the session, delete the old one.
    }


    function login($email, $password, $db_connection) {


        $table = "users";
        //query to find user by username
        $query ="select * from $table where email=\"$email\"";

        //send out query
        $result = $db_connection->query($query);

        //check result from query
        if(!$result) {

            //something went wrong with the requrest
            return false;

        } else {

            //request went through, check the results
            $num_rows = $result->num_rows;

            //check results from query. It reutnrs the rows from the db that matched the query
            if ($num_rows == 0) {

                //no rows found -> no user with email given  exists
                return false;

            } else {

                //found a row in the db matching the email given

                //get first row -> there should only be one row anyway as email are unique
                $result->data_seek(0);

                //get array with the columns  from the row found
                $row = $result->fetch_array(MYSQLI_ASSOC);

                //retrieve password stored in db
                $db_password = $row['password'];

                $pass = password_hash($password, PASSWORD_DEFAULT);

                //check password given against passwrd retrieved from database
                if(password_verify($password, $db_password)){
                    //password is correct
                    //get browser info
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    //save login info in session
                    $_SESSION['email'] = $email;
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['login_string'] = hash('sha256', $db_password.$user_browser);
                    $_SESSION['seed'] = $user_browser;
                    $_SESSION['user_name'] =  $row['first_name'];
                    $_SESSION['is_planner'] = $row['is_planner'];
                    
                    //login successful
                    return true;

                } else {

                    //password is not correct, login unsuccessful
                    return false;

                }
            }
        }
    }

    function logout($db_connection){
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
    }

    function login_check($db_connection){

        //check if all session variables are set
        if(isset($_SESSION['user_id'],
                            $_SESSION['email'],
                            $_SESSION['login_string'])) {

            $user_id = $_SESSION['user_id'];
            $email = $_SESSION['email'];
            $login_string =  $_SESSION['login_string'];



            $table = "users";
            //query to find user by username
            $query ="select * from $table where id=\"$user_id\"";

            //send out query
            $result = $db_connection->query($query);

            //check result from query
            if(!$result) {

                //something went wrong with the requrest
                //not logged in
                return false;

            } else {

                //request went through, check the results
                $num_rows = $result->num_rows;

                //check results from query. It reutnrs the rows from the db that matched the query
                if ($num_rows == 0) {

                    //no rows found -> no user with user_id  exists
                    //not logged in
                    return false;

                } else {

                    //found a row in the db matching the user_id given

                    //get browser info
                    $user_browser =  $_SESSION['seed'];

                    //get first row -> there should only be one row anyway as email are unique
                    $result->data_seek(0);

                    //get array with the columns  from the row found
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    //retrieve password stored in db
                    $db_password = $row['password'];

                    //hash the db password with the brownser info to verify it
                    $login_check = hash('sha256', $db_password.$user_browser);

                    //check saved login string against login check
                    if(hash_equals($login_check, $login_string)){

                        //login successful
                        return true;

                    } else {

                        //not logged in
                        return false;

                    }
                }
            }
        } else {
            //not logged in
            return false;
        }
    }



    function fetch_user_by_id($db_connection, $user_id, $isPlanner=false){
        $table;

        if($isPlanner){
          $table = "planners";
        } else {
          $table = "users";
        }

        $query = "select * from $table where id='$user_id'";

        //send out query
        $result = $db_connection->query($query);

         //check result from query
        if(!$result) {

            //something went wrong with the requrest
            return null;

        } else {
             //request went through, check the results
            $num_rows = $result->num_rows;

            //check results from query. It reutnrs the rows from the db that matched the query
            if ($num_rows == 0) {

                //no rows found -> no event from choosen category
                return null;

            } else {


                //get first row -> there should only be one row anyway as ids are unique
                $result->data_seek(0);

                //get array with the columns  from the row found
                $row = $result->fetch_array(MYSQLI_ASSOC);

                return $row;
            }
        }
    }




    function fetch_user_by_email($db_connection, $email){
        $table = "users";

        $query = "select * from $table where email='$email'";

        //send out query
        $result = $db_connection->query($query);

         //check result from query
        if(!$result) {

            //something went wrong with the requrest
            return null;

        } else {
             //request went through, check the results
            $num_rows = $result->num_rows;

            //check results from query. It reutnrs the rows from the db that matched the query
            if ($num_rows == 0) {

                //no rows found -> no event from choosen category
                return null;

            } else {


                //get first row -> there should only be one row anyway as ids are unique
                $result->data_seek(0);

                //get array with the columns  from the row found
                $row = $result->fetch_array(MYSQLI_ASSOC);

                return $row;
            }
        }
    }

    function query_event_by_organization($db_connection, $search_term, $event_status, $publish_status, $cleaned_organization){
        $table = "events";

        $query = "select * from $table where event_status = '$event_status' AND publish_status = '$publish_status'";

        //clean search term
        if($cleaned_organization && $search_term !== null){

            $search_term = str_replace(' ', '', strtolower($search_term));
            $query .= " AND organization = '$search_term'";
        }

        $query .= " ORDER BY start_datetime, organization";


        //send out query
        $result = $db_connection->query($query);

        //check result from query
        if(!$result) {


            //something went wrong with the requrest
            return null;

        } else {

            //request went through, check the results
            $num_rows = $result->num_rows;

            //check results from query. It reutnrs the rows from the db that matched the query
            if ($num_rows == 0) {

                //no rows found -> no event from choosen category
                 return null;

            } else {

                return $result;
            }
        }

    }

    function query_event_by_type($db_connection, $event_type, $event_status, $publish_status){
        $table = "events";

         //query to find all events
        $query = "select * from $table where";

        if($event_type !== 'all-events'){

            $query .= " event_type = '$event_type' AND";
        }

        $query .= "  event_status = '$event_status' AND publish_status = '$publish_status' ORDER by start_datetime" ;

        //send out query
        $result = $db_connection->query($query);

        //check result from query
        if(!$result) {

            //something went wrong with the requrest
            return null;

        } else {

            //request went through, check the results
            $num_rows = $result->num_rows;

            //check results from query. It reutnrs the rows from the db that matched the query
            if ($num_rows == 0) {

                //no rows found -> no event from choosen category
                 return null;

            } else {

                return $result;
            }
        }
    }


    function checkUserExists($db_connection, $email){

        $table = "users";

        $query = "select * from $table where email='$email'";

        //send out query
        $result = $db_connection->query($query);

         //check result from query
        if(!$result) {

            //something went wrong with the requrest
            return false;

        } else {

             //request went through, check the results
            $num_rows = $result->num_rows;

            //check results from query. It reutnrs the rows from the db that matched the query
            if ($num_rows == 0) {

                //no rows found -> no event from choosen category
                return false;

            } else {

                //user in the table
                return true;
            }
        }

    }



    function insert_user($db_connection, $fistname, $lastname, $email, $password, $avatar, $is_planner){

        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email, first_name, last_name, password, avatar, is_planner)
                VALUES ('$email', '$fistname', '$lastname', '$password', '$avatar', '$is_planner')";

        return $db_connection->query($query);

    }

    function insert_event($db_connection, $planner_id, $organization, $title, $event_type, $location, $start_datetime, $end_datetime, $description, $event_status, $publish_status, $picture){

        $query = "INSERT INTO events (planner_id, organization, title, event_type, location, start_datetime, end_datetime, description, event_status, publish_status, picture)
                VALUES ('$planner_id', '$organization', '$title', '$event_type', '$location', '$start_datetime', '$end_datetime', '$description', '$event_status', '$publish_status', '$picture')";

        return $db_connection->query($query);

    }

    function insert_planner($db_connection, $id, $organization, $phone_number, $website){
        $cleaned_organization = strtolower(str_replace(' ', '', $organization));

        $query = "INSERT INTO planners (id, organization, cleaned_organization, phone_number, website)
                VALUES ('$id', '$organization', '$cleaned_organization', '$phone_number', '$website')";

        return $db_connection->query($query);

    }

    function get_user_avatar($db_connection, $user_id){

        //get user data
        $data = fetch_user_by_id($db_connection, $user_id, false);

        //check user data was actually returned
        if($data !== null ){

            //return the image
            return $data['avatar'];

        } else {
            return null;
        }
    }



?>