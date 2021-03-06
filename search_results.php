<?php
  include_once("support.php");
  include_once("res/events/event_functions.php");
  include_once("res/events/event_categories.php");

  $search_term = null;
  $search_category = "all-events";
  $events_listing = "";
  $byEventType = true;
  $event_found = false;
  $search_result_message = "";

  $logged_in = login_check($db_connection);

    //information submited by the event category blocks
    if (isset($_POST['search_category'])){

       //retrieve information
        $search_category = $_POST["search_category"];
        unset($_POST['search_category']);
        $search_result_message = "All results for <b>".$event_categories[$search_category]."</b>.";
    }

    //information submited by the nav search bar
    if (isset($_POST['search-bar-submit'])) {

       $search_category = $_POST['category'];
       $search_result_message = "All Results for ";

       if(isset($_POST['search_term']) && $_POST['search_term']  !== ""){
          $search_term = $_POST['search_term'];
          $search_result_message .= "'<i>".$search_term."'</i> in the ";
       }

       $search_result_message .= '<b>'.$event_categories[$search_category].'</b> category.';


       if($search_category === 'organization'){
          $byEventType = false;
       }

    }



    //fetch events from db
    $events_list = fetch_events($db_connection, trim($search_term),  $search_category, 'open', 'published', $byEventType);

    $list_events_rsvp = null;
    $list_events_favorited = null;

    //if user logged in, retrieve information about favirited or saved events
    if($logged_in) {
      $list_events_favorited = fetch_user_events($db_connection, $_SESSION['user_id'], false, false, false);
      $list_events_rsvp = fetch_user_events($db_connection, $_SESSION['user_id'], true, false, false);
    }

    ///check if result was returned
    if($events_list != null) {

        //found a row in the db matching the category given
        for($i = 0; $i < $events_list->num_rows; $i++){

            //get first row -> there should only be one row anyway as email are unique
            $events_list->data_seek($i);

            //get array with the columns  from the row found
            $row = $events_list->fetch_array(MYSQLI_ASSOC);

            $is_favorited = false;
            $is_rsvped = false;

            //check if events are already rsvped or saved by user
            if($list_events_rsvp != null) {
              $is_rsvped = in_array($row['id'], $list_events_rsvp);

            }

            if($list_events_favorited != null){
              $is_favorited = in_array($row['id'], $list_events_favorited);

            }


            //if searching my event type, check event titles for the search term, only list the ones that have that terms
            if($byEventType && $search_term != null) {
              if (has_search_term($row, $search_term)){

                  $event_found = true;

                  $row['organization'] =  fetch_user_by_id($db_connection, $row['planner_id'], true)['organization'];
                  $events_listing .= generate_event_box($row, $is_favorited, $is_rsvped);

              }
            } else {
                $event_found = true;

                //searching by organization name or no search time provided
                $row['organization'] =  fetch_user_by_id($db_connection, $row['planner_id'], true)['organization'];

                $events_listing .= generate_event_box($row, $is_favorited, $is_rsvped);
            }
        }

    }

    if(!$event_found) {
      // no matchin events found
      $events_listing = "<h1>No event matching your search was found :(</h1>";
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
                      <a id="all-events-btn" class="all-events nav-link orange-bg drop-right-shadow" href="#">All Events
                        <i class="list-side-panel-icon glyphicon glyphicon-plus"></i>
                      </a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('workshop')">
                      <a id="workshop-btn" class="workshop nav-link dark-pink-bg drop-right-shadow" href="#">Workshops
                        <i class="list-side-panel-icon glyphicon glyphicon-plus"></i>
                      </a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('techtalk')">
                      <a id="techtalk-btn" class="techtalk nav-link purple-bg drop-right-shadow" href="#">Tech Talks
                        <i class="list-side-panel-icon glyphicon glyphicon-plus"></i>
                      </a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('club')">
                      <a id="club-btn" class="club nav-link dark-purple-bg drop-right-shadow" href="#">Clubs
                        <i class="list-side-panel-icon glyphicon glyphicon-plus"></i>
                      </a>
                    </li>
                   <li class="nav-item"  onclick="goToEventSearchResults('other')">
                      <a id="other-btn" class="other nav-link teal-bg drop-right-shadow" href="#">Others
                        <i class="list-side-panel-icon glyphicon glyphicon-plus"></i>
                      </a>
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
            <h3>$search_result_message</h3>

              $events_listing

              <div class="event-pagination">
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                  </ul>
                </nav>
              </div>



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

  echo"<script>update_search_box('$search_term', '$search_category');</script>";
  echo "<script>update_search_categories('$search_category');</script>";

  if(isset($_SESSION['failed_action']) && $_SESSION['failed_action'] === true){
    echo "<script>ask_to_login()</script>";
    unset($_SESSION['failed_action']);
  }

?>