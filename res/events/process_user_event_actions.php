<?php
    include_once "../db/db_connect.php";
    include_once "../db/functions.php";


    sec_session_start();

    //url to previous page
    $from = $_SERVER['HTTP_REFERER'];

    if(login_check($db_connection)){


        $user_id = $_SESSION['user_id'];

        $message = "";
        $error_msg = "";
        $table;
        $event_id = $_POST['event_id'];

        if(isset($_POST['favorite'])) {

            $table = 'favorited_events';

        } else if (isset($_POST['rsvp'])){


            $table = 'rsvp_list';

        } else if (isset($_POST['export'])){


            header('Location:'.$from);
            die();
        }

        //query to check if event is already in the list
        $query = "select * from $table where user_id='$user_id', event_id='$event_id'";

        $res = $db_connection->query($query);

        if(!$res) {

            //no results! so add new list to table
            $query = "INSERT INTO $table (user_id, event_id) VALUES ('$user_id', '$event_id')";

            if(!$db_connection->query($query)){
                $_SESSION['action_completed'] = "Uh oh, there was a problem processing your request. Please refresh the page and try again!";
            }
        } else {
            $_SESSION['failed_action'] = false;

        }

    } else{

        $_SESSION['failed_action'] = true;
    }

        //return to prev page
        header('Location:'.$from);

?>