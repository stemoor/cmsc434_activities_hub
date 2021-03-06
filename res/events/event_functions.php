<?php

    $event_catergories_colors['all'] = "orange";
    $event_catergories_colors['workshop'] = "dark-pink";
    $event_catergories_colors['techtalk'] = "purple";
    $event_catergories_colors['club'] = "dark-purple";
    $event_catergories_colors['other'] = "teal";


    function generate_event_box($data, $is_favorited, $is_rsvped){
        global  $db_connection;
        global $logged_in;
        global  $event_catergories_colors;


        $event_type = ucfirst($data['event_type']);

        $image = "src='imgs/event_place_holder_img.png'";
        if($data['picture'] !== null){
            $image = "src='data:image/png;base64," . base64_encode($data['picture'])."'";
        }

        $event_box = <<<EOBOX


            <!--<event listing {$data['id']}>-->
              <div id="event{$data["id"]}" class="list-item right-border {$event_catergories_colors[$data['event_type']]}-border drop-right-shadow">

                <!-- list-item-body -->
                <div class="row list-item-body">

                  <!--list-item-image-->
                  <div class="col-sm-3">
                    <div class="list-item-img-container drop-right-shadow">
                      <img $image class="list-item-img"></img>
                    </div>
                  </div>
                  <!-- </list-item-image> -->

                  <!--description -->
                  <div class="col-sm-7">

                    <!--list-item-title-->
                    <div class="list-item-header">
                       <h4 class="list-item-title">{$data['title']}</h4>
                       <h5 class="list-item-subtitle">{$data['organization']}</h5>
                    </div>
                    <!--list-item-title--->

                    <div class="list-item-info">
                        <p class=""> Event Type: {$event_type}</p>
                        <p class=""> Start Date: {$data['start_datetime']}</p>
                        <p class=""> End Date: {$data['end_datetime']}</p>
                        <p class=""> Location: {$data['location']}</p>
                    </div>
                    <!-- </list-item-info> -->

                  </div>

                  <!--list-item-btns-->
                  <div class="col-sm-2">
                    <div class="list-item-btns basic_user_features">
                        <form action="res/events/process_user_event_actions.php" method="POST">
                            <button type="submit" name="favorite" id="fav-btn" class='btn btn-info btn-lg gray-bg
EOBOX;

                if($is_favorited){
                    $event_box .= " selected disabled'><span class='list-item-btn-icons glyphicon glyphicon-star'></span>";

                } else{
                    $event_box .= "'><span class='list-item-btn-icons glyphicon glyphicon-star-empty'></span>";
                }

 $event_box .= <<<EOBOX

                            Favorite</button>

                            <button type="submit" name="rsvp" id="rsvp-btn" class='btn btn-info btn-lg gray-bg
EOBOX;

                if($is_rsvped){
                    $event_box .= " selected disabled'><span class='list-item-btn-icons glyphicon glyphicon-check'></span>";

                } else{
                    $event_box .= "'><span class='list-item-btn-icons glyphicon glyphicon-unchecked'></span>";
                }

 $event_box .= <<<EOBOX


                            RSVP
                            </button>

                            <button type="submit" name="export" id="export-btn" class="btn btn-info btn-lg gray-bg ">
                              <span class="list-item-btn-icon glyphicon glyphicon-calendar"></span> Export
                            </button>

                            <input type="hidden" name="event_id" value="{$data['id']}">

                        </form>
                    </div>

EOBOX;

    //check if planner can modify this event
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] === $data['planner_id']) {
        $event_box .= <<<EOBOX

                    <div class="list-item-btns planner_features">
                        <form action="res/events/process_planner_event_actions.php" method="POST">
                            <button type="submit" name="close-event" id="" class="btn btn-info btn-lg gray-bg" >
                              <span class="list-item-btn-icons glyphicon glyphicon-remove"></span> Close
                            </button>

                            <button type="submit" name="unpublish" id="" class="btn btn-info btn-lg gray-bg">
                              <span class="list-item-btn-icon glyphicon glyphicon-eye-close"></span> Unpublish
                            </button>

                            <button type="submit" name="list-guests" id="" class="btn btn-info btn-lg gray-bg">
                              <span class="list-item-btn-icon glyphicon glyphicon-list"></span> Atendees
                            </button>


                            <input type="hidden" name="event_id" value="{$data['id']}">

                        </form>
                    </div>


EOBOX;
    }


        $event_box .= <<<EOBOX


                  </div>
                  <!--</list-item-btns>-->

                </div>
                <!--</list-item-body>-->

                <!--list item footer -->
                <div class="row">
                  <div class="col-sm-12">
                    <div class="dropdown list-item-footer">
                      <a class="btn" href="#description{$data['id']}" data-toggle="collapse"
                         aria-expanded="false" aria-controls="description1">
                        Event Description <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description{$data['id']}">
                      <div class="card card-body list-item-description">
                        <h2>About the event</h2><br>
                        <pre>
                            {$data['description']}"
                        </pre>
                      </div>
                    </div>

                  </div>
                </div>
                <!--</list-item-footer> -->

              </div>
              <!--</list-item>-->


EOBOX;



    return $event_box;

    }


     function fetch_events($db_connection, $search_term, $event_type, $event_status, $publish_status, $byEventType){

        $result = null;

        if($byEventType){
             echo "<script>console.log('query by type = $event_type')</script>";

            $result = query_event_by_type($db_connection, $event_type,  $event_status, $publish_status);
        } else {
            echo "<script>console.log('query by organization')</script>";

            $result = query_event_by_organization($db_connection, $search_term,  $event_status, $publish_status, true);
        }

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

    function has_search_term($event, $search_term){
        $title = strtolower($event['title']);
        $search_term = strtolower($search_term);
        $terms = explode(' ', $search_term);

        for($i = 0; $i < count($terms); $i++){
            echo "<script>console.log('{$terms[$i]} + title = $title')</script>";
            $pos = strpos($title, $terms[$i]) ;
            if($pos !== false){
                return true;
            }
        }

        return false;
    }

    function fetch_user_events($db_connection, $user_id, $from_rsvp_list, $include_event_info){


        $table = 'favorited_events';

        //stablish the table to query
        if($from_rsvp_list){
            $table = 'rsvp_list';
        }

        #query the table for list of events
        $query = "SELECT event_id from $table where user_id = '$user_id'";

        $result = $db_connection->query($query);

        if(!$result){

            //something went bad with db
            return null;
        } else if($result->num_rows > 0){
            //grab each event
            $data;


            $count = 0;
            for($i = 0; $i < $result->num_rows; $i++){

                //get current row
                $result->data_seek($i);

                //get array with the columns  from the row found
                $row = $result->fetch_array(MYSQLI_ASSOC);

                //get the event id
                $event_id = $row['event_id'];

                if($include_event_info) {

                     //now query database for the event info from events table order by morst rescent
                    $query = "select * from events where id='$event_id' and event_status = 'open'and publish_status = 'published' order by start_datetime DESC";

                    $event = $db_connection->query($query);

                    if(!$event){

                        //something went wrong with database
                        return null;

                    } else if ($event->num_rows > 0){

                        //get first element, there should only be one, so add it to final list
                        $event->data_seek(0);
                        $data[$count] = $event->fetch_array(MYSQLI_ASSOC);
                        $count++;
                    }

                } else {

                    //no need for event information, just add the event id to the data
                    $data[$count] = $event_id;
                    $count++;
                }

            }

            return $data;
        }

    }

    function fetch_planner_events($db_connection, $user_id, $publish_status){

        $query = "select * from events where planner_id = '$user_id' and publish_status = '$publish_status' order by start_datetime";

        $res = $db_connection->query($query);

        if(!$res) {
            //oops, something went wrong with the database;
            echo "problem in db";
            return null;
        } else {

            if($res->num_rows > 0){
                return $res;
            }
        }

        //no match found
        return null;

    }


    function get_list_of_guests($event_id, $include_guest_info){
        global  $db_connection;

        $query = "select user_id from rsvp_list where event_id = '$event_id'";

        $res = $db_connection->query($query);

        if(!$res){
            return null;
        } else {
            return $res;
        }

    }

    function generate_planner_event_box($data){
        global  $db_connection;
        global  $logged_in;
        global  $event_catergories_colors;

        $num_guests = get_list_of_guests($data['id'], false);

        if($num_guests === null){
            $num_guests = 0;
        } else {
            $num_guests = $num_guests->num_rows;
        }


        $event_type = ucfirst($data['event_type']);

        $image = "src='imgs/event_place_holder_img.png'";
        if($data['picture'] !== null){
            $image = "src='data:image/png;base64," . base64_encode($data['picture'])."'";
        }

        $event_box = <<<EOBOX


            <!--<event listing {$data['id']}>-->
              <div id="event{$data["id"]}" class="list-item right-border {$event_catergories_colors[$data['event_type']]}-border drop-right-shadow">

                <!-- list-item-body -->
                <div class="row list-item-body">

                  <!--list-item-image-->
                  <div class="col-sm-3">
                    <div class="list-item-img-container drop-right-shadow">
                      <img $image class="list-item-img"></img>
                    </div>
                  </div>
                  <!-- </list-item-image> -->

                  <!--description -->
                  <div class="col-sm-7">

                    <!--list-item-title-->
                    <div class="list-item-header">
                       <h4 class="list-item-title">{$data['title']}</h4>
                       <h5 class="list-item-subtitle">{$data['organization']}</h5>
                    </div>
                    <!--list-item-title--->

                    <div class="list-item-info">
                        <p class=""> Event Type: {$event_type}</p>
                        <p class=""> Start Date: {$data['start_datetime']}</p>
                        <p class=""> End Date: {$data['end_datetime']}</p>
                        <p class=""> Location: {$data['location']}</p>
                    </div>
                    <!-- </list-item-info> -->

                  </div>

                  <!--list-item-btns-->
                  <div class="col-sm-2">
                    <div class="list-item-btns planner_features">
                        <form action="res/events/process_planner_event_actions.php" method="POST">
                            <button type='submit' name='close-event' class='btn btn-info btn-lg gray-bg


EOBOX;

                if($data['event_status'] === 'closed'){
                    $event_box .= "'><span class='list-item-btn-icons glyphicon glyphicon-eye-open'></span> Open";

                } else{
                    $event_box .= " selected'><span class='list-item-btn-icons glyphicon glyphicon-eye-close'></span> Close";
                }

 $event_box .= <<<EOBOX

                            </button>


EOBOX;

                if($data['publish_status'] === 'published'){
                    $event_box .= "<button type='submit' name='unpublish' class='btn btn-info btn-lg gray-bgselected'><span class='list-item-btn-icon glyphicon glyphicon-minus'></span> Unpublish";

                } else{
                    $event_box .= "<button type='submit' name='publish' class='btn btn-info btn-lg gray-bg'><span class='list-item-btn-icons glyphicon glyphicon-send'></span> Publish";
                }

 $event_box .= <<<EOBOX

                            </button>

                            <button type="submit" name="list-guests" id="" class="btn btn-info btn-lg gray-bg">
                              ($num_guests) Atendee(s)
                            </button>


                            <input type="hidden" name="event_id" value="{$data['id']}">

                        </form>
                    </div>

                  </div>
                  <!--</list-item-btns>-->

                </div>
                <!--</list-item-body>-->

                <!--list item footer -->
                <div class="row">
                  <div class="col-sm-12">
                    <div class="dropdown list-item-footer">
                      <a class="btn" href="#description{$data['id']}" data-toggle="collapse"
                         aria-expanded="false" aria-controls="description1">
                        Event Description <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description{$data['id']}">
                      <div class="card card-body list-item-description">
                        <h2>About the event</h2><br>
                        <pre>
                            {$data['description']}"
                        </pre>
                      </div>
                    </div>

                  </div>
                </div>
                <!--</list-item-footer> -->

              </div>
              <!--</list-item>-->


EOBOX;



    return $event_box;

    }

?>