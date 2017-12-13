<?php

    require("../db/db_connect.php");
    require("../db/functions.php");

    sec_session_start();

    //make sure information was submitted
    if (isset($_POST["new-event-submit"])) {

        //retrieve information

        $planner_id = $_SESSION['user_id'];
        $event_type = trim($_POST["new-event-category"]);
        $title = trim($_POST["event_name"]);
        $location= trim($_POST["location"]);
        $start_datetime = $_POST["start-datetime"];
        $end_datetime = $_POST["end-datetime"];
        $publish_status = $_POST["publish"] === "true" ? "published" : "unpublished";
        $event_status = $publish_status === "published" ? "open" : "closed";
        $description = trim($_POST['description']);
        $picture = null;

        //get organization name
        $res = $db_connection->query("select organization from planners where id = '$planner_id'");
        if($res && $res->num_rows > 0){
          echo "found match";
          $res->data_seek(0); //should only have on result
          $organization =  $res->fetch_array(MYSQLI_ASSOC)['organization'];
        } else {
          $organization = $_SESSION['user_name'];
        }

        //image is optional so check if uploaded
        if(isset($_FILES["event_pic"])){
            $file_name = $_FILES["event_pic"]["tmp_name"];
            $picture = addslashes(file_get_contents($file_name));
        }

        //something went wrong :)
        $from = $_SERVER['HTTP_REFERER'];

        //attempt to add user to db
        if(insert_event($db_connection, $planner_id, $organization, $title, $event_type, $location, $start_datetime, $end_datetime, $description, $event_status, $publish_status, $picture)){
           $_SESSION['event_createdted'] = true;

        } else {
            $_SESSION['event_created'] = false;
        }

        header('Location:'.$from);
    }

?>