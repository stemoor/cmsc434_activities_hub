<?php
  include_once("../support.php");

  $body = <<<EOPAGE

      <!-- results section Section -->
      <section class="" id="events-list">
        <div class="container section-body">
          <div class="row">
            <!--control pannel -->
            <div class="col-sm-4 list-control-wrapper">
              <div class="list-control-panel">
                <div class="control-panel-nav">
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a id="all-categories-btn" class="nav-link" href="#"><i class="list-icon glyphicon glyphicon-plus"></i>All Categories</a>
                    </li>
                    <li class="nav-item">
                      <a id="workshops-btn" class="nav-link green-bg" href="#"><i class="list-icon glyphicon glyphicon-minus"></i>Workshops</a>
                    </li>
                    <li class="nav-item">
                      <a id="techtalk-btn" class="nav-link purple-bg" href="#"><i class="list-icon glyphicon glyphicon-minus"></i>TechTalks</a>
                    </li>
                    <li class="nav-item">
                      <a id="clubs-btn" class="nav-link teal-bg" href="#"><i class="list-icon glyphicon glyphicon-minus"></i>Clubs</a>
                    </li>
                  </ul>
                </div>

              </div>
            </div>
            <!--</conrol panel>-->

            <!--list of events-->
            <div class="col-sm-8 list-wrapper">

              <!--<event listing 1>-->
              <div id="event1" class="search-box right-border purple-border">
                <!-- event body-->
                <div class="row">

                  <!--image-->
                  <div class="col-sm-3">
                    <div class="event-prev-imag-wrapper">
                      <div class="event-prev-img"></div>
                    </div>
                  </div>

                  <!--description -->
                  <div class="col-sm-7">
                    <!--event title-->
                    <div class="header-box">
                       <h4 class="event-title">Tech Talk Event</h4>
                       <h5 class="organization-name">Organization Name</h5>
                    </div>
                    <!--event title-->

                    <div class="right-date-box">
                        <p class=""> Date: 11/7/2017  </p>
                        <p class=""> Time: 7:00 pm  </p>
                        <p class=""> Location: CSIC Room 2117  </p>
                    </div>
                  </div>

                  <!--buttons-->
                  <div class="col-sm-2">
                    <div class="event-list-btn">
                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="	glyphicon glyphicon-star-empty"></span> Favotire
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box">
                        <span class="glyphicon glyphicon-envelope"></span> RSVP
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="		glyphicon glyphicon-calendar"></span> Export
                      </button>
                    </div>

                  </div>
                  <!--</buttons>-->
                </div>
                <!--</event body>-->

                <!--search box footer -->
                <div class="row">
                  <div class="col-sm-12">
                    <div class="dropdown search-box-footer">
                      <a class="btn" href="#description1" data-toggle="collapse"
                         aria-expanded="false" aria-controls="description1">
                        <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description1">
                      <div class="card card-body search-box-description">
                        <h2>Abour the event</h2><br>
                        <p>
                          Want to meet new people? Want to eat free food? then come on down to the STAMP Student Union this Thursday and eat free food while meeting new people!
                          lorem ipsum dolor sit amet, consectetur adipiscing elit.<br><br>

                          Nam eleifend, odio quis condimentum bibendum, massa diam feugiat ipsum, ut tempor lorem est non purus. <br>
                          Aenean ut porttitor sem. Praesent sollicitudin ornare euismod. Sed augue leo, ultricies eget mi fringilla, blandit efficitur mauris. <br><br>

                          Ut at scelerisque libero. Pellentesque iaculis eget libero a egestas. Maecenas posuere maximus magna quis euismod. <br>
                          Suspendisse et neque egestas nulla vehicula faucibus congue vitae diam. <br><br>

                          Maecenas commodo tempus posuere. Maecenas elementum aliquam sollicitudin. <br>
                          Aenean non fringilla dui, sit amet rhoncus augue. Vestibulum aliquam egestas fringilla. <br>
                          Morbi at magna eget enim venenatis vulputate eu in libero. <br>
                          Proin eget turpis venenatis est bibendum ultricies. Integer malesuada fermentum hendrerit. <br><br>

                          Cras nec varius felis, in tristique nisl. Quisque vel est convallis elit molestie tincidunt. s<br><br>
                        </p>
                      </div>
                    </div>

                  </div>
                </div>
                <!--</search box footer> -->

              </div>
              <!--</event search-box>-->

              <!--<event listing 1>-->
              <div id="event2" class="search-box right-border green-border">
                <!-- event body-->
                <div class="row">

                  <!--image-->
                  <div class="col-sm-3">
                    <div class="event-prev-imag-wrapper">
                      <div class="event-prev-img"></div>
                    </div>
                  </div>

                  <!--description -->
                  <div class="col-sm-7">
                    <!--event title-->
                    <div class="header-box">
                       <h4 class="event-title">Professional Workshop Event</h4>
                       <h5 class="organization-name">Organization Name</h5>
                    </div>
                    <!--event title-->
                    <div class="right-date-box">
                        <p class="normal"> Date: 11/7/2017  </p>
                        <p class="normal"> Time: 7:00 pm  </p>
                        <p class="normal"> Location: CSIC Room 2117  </p>
                    </div>
                  </div>

                  <!--buttons-->
                  <div class="col-sm-2">
                    <div class="event-list-btn">
                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="	glyphicon glyphicon-star-empty"></span> Favotire
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box">
                        <span class="glyphicon glyphicon-envelope"></span> RSVP
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="glyphicon glyphicon-calendar"></span> Export
                      </button>
                    </div>

                  </div>
                  <!--</buttons>-->
                </div>
                <!--</event body>-->

                <!--search box footer -->
                <div class="row">
                  <div class="col-sm-12">
                    <div class="dropdown search-box-footer">
                      <a class="btn" href="#description2" data-toggle="collapse"
                         aria-expanded="false" aria-controls="description2">
                        <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description2">
                      <div class="card card-body search-box-description">
                        <p>
                          Want to meet new people? Want to eat free food? then come on down to the STAMP Student Union this Thursday and eat free food while meeting new people!
                          lorem ipsum dolor sit amet, consectetur adipiscing elit.<br><br>

                          Nam eleifend, odio quis condimentum bibendum, massa diam feugiat ipsum, ut tempor lorem est non purus. <br>
                          Aenean ut porttitor sem. Praesent sollicitudin ornare euismod. Sed augue leo, ultricies eget mi fringilla, blandit efficitur mauris. <br><br>

                          Ut at scelerisque libero. Pellentesque iaculis eget libero a egestas. Maecenas posuere maximus magna quis euismod. <br>
                          Suspendisse et neque egestas nulla vehicula faucibus congue vitae diam. <br><br>

                          Maecenas commodo tempus posuere. Maecenas elementum aliquam sollicitudin. <br>
                          Aenean non fringilla dui, sit amet rhoncus augue. Vestibulum aliquam egestas fringilla. <br>
                          Morbi at magna eget enim venenatis vulputate eu in libero. <br>
                          Proin eget turpis venenatis est bibendum ultricies. Integer malesuada fermentum hendrerit. <br><br>

                          Cras nec varius felis, in tristique nisl. Quisque vel est convallis elit molestie tincidunt. s<br><br>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <!--</search box footer> -->

              </div>
              <!--</event search-box>-->



              <!--<event listing 2>-->
              <div id="event3" class="search-box right-border teal-border">
                <!-- event body-->
                <div class="row">

                  <!--image-->
                  <div class="col-sm-3">
                    <div class="event-prev-imag-wrapper">
                      <div class="event-prev-img"></div>
                    </div>
                  </div>

                  <!--description -->
                  <div class="col-sm-7">
                    <!--event title-->
                    <div class="header-box">
                       <h4 class="event-title">Club Meeting Event</h4>
                       <h5 class="organization-name">Organization Name</h5>
                    </div>
                    <!--event title-->
                    <div class="right-date-box">
                        <p class="normal"> Date: 11/7/2017  </p>
                        <p class="normal"> Time: 7:00 pm  </p>
                        <p class="normal"> Location: CSIC Room 2117  </p>
                    </div>
                  </div>

                  <!--buttons-->
                  <div class="col-sm-2">
                    <div class="event-list-btn">
                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="glyphicon glyphicon-star-empty"></span> Favotire
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box">
                        <span class="glyphicon glyphicon-envelope"></span> RSVP
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="		glyphicon glyphicon-calendar"></span> Export
                      </button>
                    </div>

                  </div>
                  <!--</buttons>-->
                </div>
                <!--</event body>-->

                <!--search box footer -->
                <div class="row">
                  <div class="col-sm-12">
                    <div class="dropdown search-box-footer">
                      <a class="btn" href="#description3" data-toggle="collapse"
                         aria-expanded="false" aria-controls="description3">
                        <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description3">
                      <div class="card card-body search-box-description">
                        <p>
                          Want to meet new people? Want to eat free food? then come on down to the STAMP Student Union this Thursday and eat free food while meeting new people!
                          lorem ipsum dolor sit amet, consectetur adipiscing elit.<br><br>

                          Nam eleifend, odio quis condimentum bibendum, massa diam feugiat ipsum, ut tempor lorem est non purus. <br>
                          Aenean ut porttitor sem. Praesent sollicitudin ornare euismod. Sed augue leo, ultricies eget mi fringilla, blandit efficitur mauris. <br><br>

                          Ut at scelerisque libero. Pellentesque iaculis eget libero a egestas. Maecenas posuere maximus magna quis euismod. <br>
                          Suspendisse et neque egestas nulla vehicula faucibus congue vitae diam. <br><br>

                          Maecenas commodo tempus posuere. Maecenas elementum aliquam sollicitudin. <br>
                          Aenean non fringilla dui, sit amet rhoncus augue. Vestibulum aliquam egestas fringilla. <br>
                          Morbi at magna eget enim venenatis vulputate eu in libero. <br>
                          Proin eget turpis venenatis est bibendum ultricies. Integer malesuada fermentum hendrerit. <br><br>

                          Cras nec varius felis, in tristique nisl. Quisque vel est convallis elit molestie tincidunt. s<br><br>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <!--</search box footer> -->

              </div>
               <!--</event search-box>-->


              <!--<event listing 4>-->
              <div id="event4" class="search-box right-border purple-border" style="display:none;">
                <!-- event body-->
                <div class="row">

                  <!--image-->
                  <div class="col-sm-3">
                    <div class="event-prev-imag-wrapper">
                      <div class="event-prev-img"></div>
                    </div>
                  </div>

                  <!--description -->
                  <div class="col-sm-7">
                    <!--event title-->
                    <div class="header-box">
                       <h4 class="event-title">Tech Talk Event</h4>
                       <h5 class="organization-name">Organization Name</h5>
                    </div>
                    <!--event title-->

                    <div class="right-date-box">
                        <p class=""> Date: 11/7/2017  </p>
                        <p class=""> Time: 7:00 pm  </p>
                        <p class=""> Location: CSIC Room 2117  </p>
                    </div>
                  </div>

                  <!--buttons-->
                  <div class="col-sm-2">
                    <div class="event-list-btn">
                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="	glyphicon glyphicon-star-empty"></span> Favotire
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box">
                        <span class="glyphicon glyphicon-envelope"></span> RSVP
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="		glyphicon glyphicon-calendar"></span> Export
                      </button>
                    </div>

                  </div>
                  <!--</buttons>-->
                </div>
                <!--</event body>-->

                <!--search box footer -->
                <div class="row">
                  <div class="col-sm-12">
                    <div class="dropdown search-box-footer">
                      <a class="btn" href="#description4" data-toggle="collapse"
                         aria-expanded="false" aria-controls="description4">
                        <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description4">
                      <div class="card card-body search-box-description">
                        <h2>Abour the event</h2><br>
                        <p>
                          Want to meet new people? Want to eat free food? then come on down to the STAMP Student Union this Thursday and eat free food while meeting new people!
                          lorem ipsum dolor sit amet, consectetur adipiscing elit.<br><br>

                          Nam eleifend, odio quis condimentum bibendum, massa diam feugiat ipsum, ut tempor lorem est non purus. <br>
                          Aenean ut porttitor sem. Praesent sollicitudin ornare euismod. Sed augue leo, ultricies eget mi fringilla, blandit efficitur mauris. <br><br>

                          Ut at scelerisque libero. Pellentesque iaculis eget libero a egestas. Maecenas posuere maximus magna quis euismod. <br>
                          Suspendisse et neque egestas nulla vehicula faucibus congue vitae diam. <br><br>

                          Maecenas commodo tempus posuere. Maecenas elementum aliquam sollicitudin. <br>
                          Aenean non fringilla dui, sit amet rhoncus augue. Vestibulum aliquam egestas fringilla. <br>
                          Morbi at magna eget enim venenatis vulputate eu in libero. <br>
                          Proin eget turpis venenatis est bibendum ultricies. Integer malesuada fermentum hendrerit. <br><br>

                          Cras nec varius felis, in tristique nisl. Quisque vel est convallis elit molestie tincidunt. s<br><br>
                        </p>
                      </div>
                    </div>

                  </div>
                </div>
                <!--</search box footer> -->



              </div>
              <!--</event search-box>-->

              <!--<event listing 5>-->
              <div id="event5" class="search-box right-border purple-border" style="display:none;">
                <!-- event body-->
                <div class="row">

                  <!--image-->
                  <div class="col-sm-3">
                    <div class="event-prev-imag-wrapper">
                      <div class="event-prev-img"></div>
                    </div>
                  </div>

                  <!--description -->
                  <div class="col-sm-7">
                    <!--event title-->
                    <div class="header-box">
                       <h4 class="event-title">Tech Talk Event</h4>
                       <h5 class="organization-name">Organization Name</h5>
                    </div>
                    <!--event title-->

                    <div class="right-date-box">
                        <p class=""> Date: 11/7/2017  </p>
                        <p class=""> Time: 7:00 pm  </p>
                        <p class=""> Location: CSIC Room 2117  </p>
                    </div>
                  </div>

                  <!--buttons-->
                  <div class="col-sm-2">
                    <div class="event-list-btn">
                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="	glyphicon glyphicon-star-empty"></span> Favotire
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box">
                        <span class="glyphicon glyphicon-envelope"></span> RSVP
                      </button>

                      <button type="button" class="btn btn-info btn-lg right-header-box" >
                        <span class="		glyphicon glyphicon-calendar"></span> Export
                      </button>
                    </div>

                  </div>
                  <!--</buttons>-->
                </div>
                <!--</event body>-->

                <!--search box footer -->
                <div class="row">
                  <div class="col-sm-12">
                    <div class="dropdown search-box-footer">
                      <a class="btn" href="#description5" data-toggle="collapse"
                         aria-expanded="false" aria-controls="description5">
                        <span class="glyphicon glyphicon-menu-down"></span>
                      </a>
                    </div>

                    <div class="collapse" id="description5">
                      <div class="card card-body search-box-description">
                        <h2>Abour the event</h2><br>
                        <p>
                          Want to meet new people? Want to eat free food? then come on down to the STAMP Student Union this Thursday and eat free food while meeting new people!
                          lorem ipsum dolor sit amet, consectetur adipiscing elit.<br><br>

                          Nam eleifend, odio quis condimentum bibendum, massa diam feugiat ipsum, ut tempor lorem est non purus. <br>
                          Aenean ut porttitor sem. Praesent sollicitudin ornare euismod. Sed augue leo, ultricies eget mi fringilla, blandit efficitur mauris. <br><br>

                          Ut at scelerisque libero. Pellentesque iaculis eget libero a egestas. Maecenas posuere maximus magna quis euismod. <br>
                          Suspendisse et neque egestas nulla vehicula faucibus congue vitae diam. <br><br>

                          Maecenas commodo tempus posuere. Maecenas elementum aliquam sollicitudin. <br>
                          Aenean non fringilla dui, sit amet rhoncus augue. Vestibulum aliquam egestas fringilla. <br>
                          Morbi at magna eget enim venenatis vulputate eu in libero. <br>
                          Proin eget turpis venenatis est bibendum ultricies. Integer malesuada fermentum hendrerit. <br><br>

                          Cras nec varius felis, in tristique nisl. Quisque vel est convallis elit molestie tincidunt. s<br><br>
                        </p>
                      </div>
                    </div>

                  </div>
                </div>
                <!--</search box footer> -->



              </div>
              <!--</event search-box>-->
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

EOPAGE;

  echo generate_page($body);
?>