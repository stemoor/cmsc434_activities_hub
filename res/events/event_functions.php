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

        $event_box = <<<EOBOX


            <!--<event listing {$data['id']}>-->
              <div id="{$data["id"]}" class="list-item right-border {$event_catergories_colors[$data['event_type']]}-border drop-right-shadow">

                <!-- list-item-body -->
                <div class="row list-item-body">

                  <!--list-item-image-->
                  <div class="col-sm-3">
                    <div class="list-item-img-container drop-right-shadow">
                      <div class="list-item-img"></div>
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

        if($result && $result->num_rows > 0){
            //grab each event
            $data = null;

            for($i = 0; $i < $result->num_rows; $i++){

                //get current row
                $result->data_seek($i);

                //get array with the columns  from the row found
                $row = $result->fetch_array(MYSQLI_ASSOC);

                //get the event id
                $event_id = $row['event_id'];

                if($include_event_info) {

                     //now query database for the event info from events table
                    $query = "select * from events where id='$event_id order by start_datetime DESC'";

                    $event = $db_connection->query($query);

                    if($event){
                        //get first element, there should only be one and add it to final list
                        $data[$i] = $event->data_seek(0)->fetch_array(MYSQLI_ASSOC);
                    }

                } else {
                    $data[$i] = $event_id;
                }



            }

            return $data;
        }

        return null;

    }



?>