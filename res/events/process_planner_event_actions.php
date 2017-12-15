<?php
    include_once "../db/db_connect.php";
    include_once "../db/functions.php";


    sec_session_start();

    $user_id = $_SESSION['user_id'];
    //url to previous page
    $from = $_SERVER['HTTP_REFERER'];
    $message = "";
    $error_msg = "";
    $action;
    $event_id = $_POST['event_id'];

    if(isset($_POST['close-event'])) {

        echo "close";

        $message = "Event Closed! Users can see this event but can't RSVP!";
        $error_msg = "This event is already closed." ;
        $action = "event_status = 'closed'";

    } else if (isset($_POST['unpublish'])){

        echo "unp";

        $message = "Event has been unpublished! Users can't see this event.";
        $error_msg = "This event is already unpublished" ;
        $action = "publish_status = 'unpublished'";

    } else if (isset($_POST['publish'])){

        echo "pub";

        $message = "Event has been published! Users can now RSVP";
        $error_msg = "This event is already published" ;
        $action = "publish_status = 'published'";

    }
    else if (isset($_POST['list-guests']))  {

        //fake complete this action as we won't implement this
        $_SESSION['action_completed'] = "List of attendes for this event was sent to your email!";

        header('Location:'.$from);
        die();
    }

    //no results! so add new list to table
    $query = "UPDATE events SET $action where id='$event_id'";

    if($db_connection->query($query) === true){

        //action successfull
        $_SESSION['action_completed'] = $message;
    } else {
        echo "nah di dnot wrk";
        $_SESSION['action_completed'] = "Uh oh, there was a problem processing your request. Please refresh the page and try again!";
    }


    //return to prev page
   header('Location:'.$from);

?>