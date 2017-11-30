<?php

    $event_catergories_colors['techtalk'] = "purple";
    $event_catergories_colors['workshop'] = "green";
    $event_catergories_colors['all'] = "gray";
    $event_catergories_colors['club'] = "teal";
    $event_catergories_colors['other'] = "light-green";

    function generate_event_box($data){

        global  $event_catergories_colors;

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
                        <p class=""> Event Type: {$data['event_type']}</p>
                        <p class=""> Start Date: {$data['start_datetime']}</p>
                        <p class=""> End Date: {$data['end_datetime']}</p>
                        <p class=""> Location: {$data['location']}</p>
                    </div>
                    <!-- </list-item-info> -->

                  </div>

                  <!--list-item-btns-->
                  <div class="col-sm-2">
                    <div class="list-item-btns">
                      <button type="button" id="fav-btn" class="btn btn-info btn-lg teal-bg teal-border" >
                        <span class="list-item-btn-icons glyphicon glyphicon-star-empty"></span> Favotire
                      </button>

                      <button type="button" id="rsvp-btn" class="btn btn-info btn-lg teal-bg teal-border">
                        <span class="list-item-btn-icon glyphicon glyphicon-unchecked"></span> RSVP
                      </button>

                      <button type="button" id="export-btn" class="btn btn-info btn-lg teal-bg teal-border" >
                        <span class="list-item-btn-icon glyphicon glyphicon-calendar"></span> Export
                      </button>
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
                        <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description{$data['id']}">
                      <div class="card card-body list-item-description">
                        <h2>Abour the event</h2><br>
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
             echo "<script>console.log('query by type')</script>";

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



?>