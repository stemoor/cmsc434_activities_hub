<?php
  include_once("support.php");
  include_once("res/events/event_functions.php");
  include_once("res/events/event_categories.php");

  $search_term = null;
  $search_category = "all-events";
  $byEventType = true;

  $from_saved = "";
  $from_published = "";

  $published_status = "published";

  $from_saved = "";
  $from_saved_in = "";
  $from_published = "";
  $from_published_in = "";

  $logged_in = login_check($db_connection);
  $page_title = "Published Events";

  //in case user is loggs out form here
  $_SESSION['on_my_list'] = "true";

   //check which tab should be active
    if(isset($_GET['published']) && $_GET['published'] === "true"){
      $from_published = "active";
      $from_published_in = "in ". $from_published;
      unset($_GET['published']);
    } else{
      $published_status = "unpublished";
      $from_saved = "active";
      $from_saved_in = "in ". $from_saved;
      unset($_GET['published']);
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

    $published_data = null;
    $saved_data = null;


    //if user logged in, retrieve information about favirited or saved events
    if($logged_in) {
        $published_data =  fetch_planner_events($db_connection, $_SESSION['user_id'], 'published');
        $saved_data =  fetch_planner_events($db_connection, $_SESSION['user_id'], 'unpublished');
    }

    $published_count = 0;
    $saved_count = 0;
    $published_events_listing = "";
    $saved_events_listing = "";

    ///process rsvp events
    if($published_data != null) {

        $published_count = $published_data->num_rows;

        echo "found $published_count saved events";

        for($i = 0; $i < $published_count; $i++){

            $published_data->data_seek($i);
            $row = $published_data->fetch_array(MYSQLI_ASSOC);

            $published_events_listing .= generate_planner_event_box($row);

        }

    } else {
      // no matchin events found
      $published_events_listing = "<h3>No events in this list.</h3>";
    }


    $saved_events_listing = "";

    ///process rsvp events
    if($saved_data != null) {


        $saved_count = $saved_data->num_rows;

        echo "found $saved_count saved events";

        for($i = 0; $i < $saved_count; $i++){

            $saved_data->data_seek($i);
            $row = $saved_data->fetch_array(MYSQLI_ASSOC);

            $saved_events_listing .= generate_planner_event_box($row);
        }

    } else {
      // no matchin events found
      $saved_events_listing = "<h3>No events in this list.</h3>";
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
                  <li class="nav-item $from_published" role="presentation">
                      <a class="nav-link" data-toggle="tab" href="#publish_list"  role="tab" aria-controls="publish_list">
                        <i class="acc-modal-icon  glyphicon glyphicon-send"></i> Published Events ( $published_count )</a>
                  </li>
                  <li class="nav-item $from_saved" role="presentation">
                      <a class="nav-link" data-toggle="tab" href="#saved_list" role="tab" aria-controls="saved_list">
                        <i class="acc-modal-icon  glyphicon glyphicon-pencil"></i> Drafts ( $saved_count )</a>
                  </li>
                </ul>
               </div>
               <!-- /.events tab -->

                <!-- Tab panels -->
                <div class="tab-content card">
                    <!--Panel 1-->
                    <div class="tab-pane fade $from_published_in" id="publish_list" role="tabpanel">
                      $published_events_listing
                    </div>
                    <!--/.Panel 1-->

                    <!--Panel 2-->
                    <div class="tab-pane fade $from_saved_in" id="saved_list" role="tabpanel">
                      $saved_events_listing
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