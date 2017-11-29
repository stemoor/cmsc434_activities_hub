<?php
  include_once("support.php");
  include_once("res/events/event_functions.php");

  $events_listing = "";

    //make sure information was submitted
    if (isset($_POST['search_category'])){

        //retrieve information
        $search_term = $_POST["search_category"];

        $events_list = fetch_events($db_connection, $search_term, $_POST["search_category"]);


        if($events_list != null) {
            //found a row in the db matching the category given
            for($i = 0; $i < $events_list->num_rows; $i++){

                //get first row -> there should only be one row anyway as email are unique
                $result->datas_seek(i);

                //get array with the columns  from the row found
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $row['organization'] =  fetch_users($db_connection, row['planner_id'], true)['organization'];

                $events_listing .= generate_event_box($row);
            }

        } else {

           $events_listing .= "<h1>Nothing Found</h1>";
        }
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
                    <li class="nav-item">
                      <a id="all-events-btn" class="nav-link pink-bg drop-right-shadow" href="#">All Events<i class="list-side-panel-icon glyphicon glyphicon-plus"></i></a>
                    </li>
                    <li class="nav-item">
                      <a id="workshops-btn" class="nav-link green-bg drop-right-shadow" href="#">Workshops<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                    <li class="nav-item">
                      <a id="techtalk-btn" class="nav-link purple-bg drop-right-shadow" href="#">Tech Talks<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                    <li class="nav-item">
                      <a id="clubs-btn" class="nav-link teal-bg drop-right-shadow" href="#">Clubs<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                   <li class="nav-item">
                      <a id="other-btn" class="nav-link light-green-bg drop-right-shadow" href="#">Other<i class="list-side-panel-icon glyphicon glyphicon-minus"></i></a>
                    </li>
                  </ul>
                </div>

              </div>
            </div>
            <!--</conrol panel>-->

            <!--list of events-->
            <div class="col-sm-7 list-wrapper">

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

            <div class="col-sm-2">
            </div>

          </div>
          <!--</main body row>-->
        </div>
        <!--</main section container>-->

      </section>
      <!--</main section>-->



EOPAGE;

  echo generate_page($body,  'event-search-page');

/*
        <script>
            $("#techtalk-btn").click(function() {
              document.getElementById("event2").style.display = "none";
              document.getElementById("event3").style.display = "none";
              document.getElementById("event4").style.display =  null;
              document.getElementById("event5").style.display =  null;
              let plus_icon = "<i class='list-icon glyphicon glyphicon-plus'></i>";

              let minus_icon = "<i class='list-icon glyphicon glyphicon-minus'></i>";

              document.getElementById("all-categories-btn").innerHTML  = plus_icon + 'All Categories';
              document.getElementById("clubs-btn").innerHTML  = plus_icon + 'Club Meetings';
              document.getElementById("workshops-btn").innerHTML  = plus_icon + 'Workshops';
              document.getElementById("techtalk-btn").innerHTML  = minus_icon + 'Tech Talks';


            });

      </script>
*/

?>