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

            echo "fav";

            $table = 'favorited_events';
            $message = "Event added to your favorited list!";
            $error_msg = "You already favorited this event! Go to your account to see list of all favorited events." ;

        } else if (isset($_POST['rsvp'])){


            echo "rsvp";
            $table = 'rsvp_list';
            $message = "RSVP to event successfully!";
            $error_msg = "You are already going to this event! Go to your account to see list of all RSVPed events." ;

        } else if (isset($_POST['export'])){
            echo "export set";
            //fake complete this action as we won't implement this
            $_SESSION['action_completed'] = "Event exported to your calendar successfully!";

            header('Location:'.$from);
            die();
        }

        //query to check if event is already in the list
        $query = "select * from $table where user_id='$user_id', event_id='$event_id'";

        $res = $db_connection->query($query);

        if($res && $res->num_rows == 0 ){

            //no results! so add new list to table
            $query = "INSERT INTO $table (user_id, event_id) VALUES ('$user_id', '$event_id')";

            if($db_connection->query($query)){

                //action successfull
                $_SESSION['action_completed'] = $message;

            } else {
                $_SESSION['action_completed'] = "Uh oh, there was a problem processing your request. Please refresh the page and try again!";
            }
        } else {

            $_SESSION['action_completed'] = $error_msg;

        }

        //return to prev page
        header('Location:'.$from);
    } else{

        //return to prev page
        header('Location:'.$from."?error=5");
    }

?>