<?php

include_once("support.php");

$body = <<<EOBODY


  <div class="content">
      <!-- main section Section -->
      <section class="success" id="home">
          <!--</sectio body>-->
        <div class="section-body overlay">

          <div class="events-grid">
            <diV class="main-title">
              <h1>Looking for an event? </h1>
            </diV>

            <div class="row">
              <div id="workshop" class="col-sm-4 col-sm-offset-2 green-bg event-block event-block-btn drop-right-shadow" onclick="goToEventSearchResults('workshop')">
                <div class="card ">
                  <div class="card-block">
                   <h2>Workshops</h2>
                  </div>
                </div>
              </div>
              <div id="techtalk" class="col-sm-4 purple-bg event-block event-block-btn drop-right-shadow" onclick="goToEventSearchResults('techtalk')">
                <div class="card ">
                  <div class="card-block">
                    <h2>Tech Talks</h2>
                  </div>
                </div>
              </div>
            </div>


            <div class="row ">

              <div id="club" class="col-sm-4   col-sm-offset-2 teal-bg event-block event-block-btn drop-right-shadow" onclick="goToEventSearchResults('club')">
                <div class="card ">
                  <div class="card-block">
                    <h2>Club Meetings</h2>
                  </div>
                </div>
              </div>
              <div id="all-events" class="col-sm-4 pink-bg event-block event-block-btn drop-right-shadow" onclick="goToEventSearchResults('all-events')">
                <div class="card ">
                  <div class="card-block">
                    <h2><i class="glyphicon glyphicon-plus" ></i>All Events</h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--</events-grid>-->

          <form id="search-form" action="search_results.php" method="POST">
            <input type="hidden" id="search-category-block" name="search_category" value="all-events">
          </form>
        </div>
        <!--</main section container>-->

      </section>
      <!--</main section>-->


      <!-- About Section -->
      <section class="teal-bg" id="about">
        <div class="">

          <!--section title-->
          <div class="row main-title">
            <div class="col-lg-12 text-center">
              <h1>About Us</h1>
              <hr class="star-light">
            </div>
          </div>
          <!--</section title>-->

          <!--section body-->
          <div class="row">
            <div class="col-lg-4 col-lg-offset-2 about-text gray-bg drop-right-shadow">
              <p><h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3></p>
              <br>

              <p class="text-left">
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
                  when an unknown printer took a galley of type and scrambled it to make a type specimen book.
              </p> <br>

              <p>
                <strong>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</strong>
              </p><br>

              <p class="text-left">
                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
              </p>

            </div>

            <div class="col-lg-4 purple-bg drop-right-shadow">
              <div class="about-img "></div>
            </div>
          </div>
          <!--section body-->

        </div>
        <!--</sectin container>-->

      </section>
      <!--</about section>-->
    </div>



EOBODY;

  echo generate_page($body,  'main');
