<?php
  include_once("support.php");
  include_once("res/events/event_functions.php");
  include_once("res/events/event_categories.php");

  $search_term = null;
  $search_category = "all-events";
  $byEventType = true;
  $from_fav_list = "";
  $from_rsvp_list = "";
  $from_rsvp_list_in = "";
  $from_fav_list_in = "";

  $logged_in = login_check($db_connection);
  $page_title = "RSVPed Events";

  //in case user is loggs out form here
  $_SESSION['on_my_list'] = "true";

   //check which tab should be active
    if(isset($_GET['rsvp']) && $_GET['rsvp'] === "true"){
      $from_rsvp_list = "active";
      $from_rsvp_list_in = "in ". $from_rsvp_list;
      unset($_GET['rsvp']);
    } else{
      $from_fav_list = "active";
      $from_fav_list_in = "in ". $from_fav_list;
       unset($_GET['rsvp']);
    }

    //information submited by the event category blocks
    if (isset($_POST['search_category'])){

       //retrieve information
        $search_category = $_POST["search_category"];
        unset($_POST['search_category']);
    }

    //information submited by the nav search bar
    if (isset($_POST['search-bar-submit'])) {

       $search_category = $_POST['category'];

       if(isset($_POST['search_term'])){
          $search_term = $_POST['search_term'];
       }

       if($search_category === 'organization'){
          $byEventType = false;
       }

    }

    $rsvp_data = null;
    $favorited_data = null;
    $list_events_favorited = null;
    $list_events_rsvp = null;

    //if user logged in, retrieve information about favirited or saved events
    if($logged_in) {

      //fetch rsvp events from db
      $rsvp_data = fetch_user_events($db_connection, $_SESSION['user_id'], true, true);

      //fetch favorited events from db
      $favorited_data = fetch_user_events($db_connection, $_SESSION['user_id'], false, true);

      //fetch ids for setting buttons
      $list_events_rsvp = fetch_user_events($db_connection, $_SESSION['user_id'], true, false);
      $list_events_favorited = fetch_user_events($db_connection, $_SESSION['user_id'], false, false);
    }

    $events_listing_rsvp = "";
    $events_listing_fav = "";


    $rsvp_count = 0;
    $fav_count = 0;
    ///process rsvp events
    if($rsvp_data !== null) {

        $rsvp_count = sizeof($rsvp_data);

        for($i = 0; $i < $rsvp_count; $i++){

            $is_favorited = false;
            $is_rsvped = false;

            if($list_events_favorited != null){
              $is_favorited = in_array($rsvp_data[$i]['id'], $list_events_favorited);

            }

           $row['organization'] =  fetch_user_by_id($db_connection, $rsvp_data[$i]['planner_id'], true)['organization'];
           $events_listing_rsvp .= generate_event_box($rsvp_data[$i], $is_favorited, true);
        }

    } else {
      // no matchin events found
      $events_listing_rsvp = "<h3>No events in this list.</h3>";
    }



    ///process rsvp events
    if($favorited_data != null) {

        $fav_count = 0;
        for($i = 0; $i < sizeof($favorited_data); $i++){

            $is_rsvped = false;

            //if rsvp no need to show in the favorited
            if($list_events_rsvp != null && !in_array($favorited_data[$i]['id'], $list_events_rsvp)){
               $row['organization'] =  fetch_user_by_id($db_connection, $favorited_data[$i]['planner_id'], true)['organization'];
               $events_listing_fav .= generate_event_box($favorited_data[$i], true, $is_rsvped);
               $fav_count++;
            }
        }

    } else {
      // no matchin events found
      $events_listing_fav = "<h3>No events in this list.</h3>";
    }

    //last check for empty fav list
    if($events_listing_fav === ""){
       $events_listing_fav = "<h3>No events in this list.</h3>";
    }

  $body = <<<EOPAGE

      <!-- results section Section -->
      <section class="" id="events-list">
        <div class="section-body">

          <div class="row">
            <!--control pannel -->

            <div class="col-sm-2 list-side-panel-container">

              <div class="list-side-panel">

                <div class="list-side-panel-nav">
                  <ul class="nav flex-column">
                    <li class="nav-item" onclick="goToEventSearchResults('all-events')">
                      <a id="all-events-btn" class="all-events nav-link orange-bg drop-right-shadow" href="#">All Events<i class="list-side-panel-icon glyphicon glyphicon-plus"></i></a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('workshop')">
                      <a id="workshops-btn" class="workshop nav-link dark-pink-bg drop-right-shadow" href="#">Workshops<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('techtalk')">
                      <a id="techtalk-btn" class="techtalk nav-link purple-bg drop-right-shadow" href="#">Tech Talks<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('club')">
                      <a id="clubs-btn" class="club nav-link dark-purple-bg drop-right-shadow" href="#">Clubs<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                   <li class="nav-item"  onclick="goToEventSearchResults('other')">
                      <a id="other-btn" class="other nav-link teal-bg drop-right-shadow" href="#">Others<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                  </ul>
                </div>

              </div>

              <form id="search-form" action="search_results.php" method="POST">
                <input type="hidden" id="search-category-block" name="search_category" value="all-events">
              </form>
            </div>
            <!--</conrol panel>-->

            <!--list of events-->
            <div class="col-sm-8 list-wrapper">

              <div class="my_results_page_title">

                <!-- events tab -->
                <ul class="nav nav-tabs nav-justified" role="tablist">
                  <li class="nav-item $from_rsvp_list" role="presentation">
                      <a class="nav-link" data-toggle="tab" href="#rsvp_list"  role="tab" aria-controls="rsvp_list">
                        <i class="acc-modal-icon  glyphicon glyphicon-check"></i> RSVP Events ( $rsvp_count )</a>
                  </li>
                  <li class="nav-item $from_fav_list" role="presentation">
                      <a class="nav-link" data-toggle="tab" href="#favorite_list" role="tab" aria-controls="favorite_list">
                        <i class="acc-modal-icon  glyphicon glyphicon-star"></i> Favorite Events ( $fav_count )</a>
                  </li>
                </ul>
               </div>
               <!-- /.events tab -->

                <!-- Tab panels -->
                <div class="tab-content card">
                    <!--Panel 1-->
                    <div class="tab-pane fade $from_rsvp_list_in" id="rsvp_list" role="tabpanel">
                      $events_listing_rsvp
                    </div>
                    <!--/.Panel 1-->

                    <!--Panel 2-->
                    <div class="tab-pane fade $from_fav_list_in" id="favorite_list" role="tabpanel">
                      $events_listing_fav
                    </div>
                    <!--/.Panel 2-->

                </div>
                <!-- Tab panels -->

            </div>
            <!--</list of events>-->

          </div>
          <!--</main body row>-->

        </div>
        <!--</main section container>-->

      </section>
      <!--</main section>-->



EOPAGE;

  echo generate_page($body,  'event-search-page');
  if (isset($_POST['submit'])) {
    echo"<script>setSearchCategoryOptions('$search_category');</script>";

    unset($_POST['submit']);
    unset($_POST['search_term']);
  }
?>