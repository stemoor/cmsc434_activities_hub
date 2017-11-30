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

                    //login successful
                    return true;

                } else {

                    //password is not correct, login unsuccessful
                    return false;

                }
            }
        }
    }

    function login_check($db_connection){

        //check if all session variables are set
        if(isset($_SESSION['user_id'],
                            $_SESSION['email'],
                            $_SESSION['login_string'])) {

            $user_id = $_SESSION['user_id'];
            $email = $_SESSION['email'];
            $login_string =  $_SESSION['login_string'];

            //get browser info
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

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



    function fetch_user($db_connection, $user_id, $isPlanner=false){
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

    function query_event_by_organization($db_connection, $search_term, $event_status, $publish_status, $cleaned_organization){
        $table = "events";

        $query = "select * from $table where event_status = '$event_status' AND publish_status = '$publish_status'";

        //clean search term
        if($cleaned_organization && $search_term !== null){
            echo "<script>console.log('cleaned org $search_term ')</script>";

            $search_term = str_replace(' ', '', strtolower($search_term));
            $query .= " AND organization = '$search_term'";
        }

        $query .= " ORDER BY organization";


        //send out query
        $result = $db_connection->query($query);

        //check result from query
        if(!$result) {

             echo "<script>console.log(' !result ')</script>";
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
            echo "<script>console.log('query by type = $event_type')</script>";
            $query .= " event_type = '$event_type' AND";
        }

        $query .= "  event_status = '$event_status' AND publish_status = '$publish_status'" ;

        //send out query
        $result = $db_connection->query($query);

        //check result from query
        if(!$result) {
             echo "<script>console.log('!result')</script>";
            //something went wrong with the requrest
            return null;

        } else {

            //request went through, check the results
            $num_rows = $result->num_rows;

            //check results from query. It reutnrs the rows from the db that matched the query
            if ($num_rows == 0) {
                     echo "<script>console.log('no rows')</script>";
                //no rows found -> no event from choosen category
                 return null;

            } else {

                return $result;
            }
        }
    }



?>