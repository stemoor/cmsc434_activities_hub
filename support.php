<?php
    include_once "res/db/db_connect.php";
    include_once "res/db/functions.php";

    sec_session_start();

    $logged = false;

    //check if logged in
    if(login_check($db_connection) == true) {
        $logged = true;
        echo "<script>console.log('logged in');</script>";
    } else {
        echo "<script>console.log('not logged in PASS HASH".$_SESSION['passHASH']."');</script>";
    }


    function generate_page($body, $page) {
        $page = <<<EOPAGE

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Activities Hub</title>

    <!--google map script-->
    <script src="js/googlemap/map.js"></script>

    <!--Bootstrap core JavaScript-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Custom styles for this page -->
    <link href="css/main_style.css" rel="stylesheet">
    <link href="css/event_search_results_style.css" rel="stylesheet">
  </head>

  <body>

    <div id="$page" class="page-wrapper">
      <!--navigation bar-->
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-wrapper container ">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">
              <img alt="Brand" src="">
            </a>

            <!-- menu button for when navigation bar is collapsed for mobile-->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <!--title of the page-->
            <a class="navbar-brand navbar-left" href="index.php">Activitie Hub</a>
          </div>

          <!--add every nav bar button/link under here so it can be collapsed for mobal-->
          <div id="navbar" class="navbar-collapse collapse align-bottom">

            <!--home button-->
            <ul class="nav navbar-nav navbar-left">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="index.php#about">About</a></li>
            </ul>

            <!--search bar-->
            <div class="nav-search-field" style="display:none;">
              <form action="res/events/process_event_search.php" method="post" class="navbar-form navbar-left">

                <div class="form-group">
                    <select id="search-category" class="search form-control">
                        <option name="category" value="all" checked>All</option>
                        <option name="category" value="club">Club</option>
                        <option name="category" value="techtalk">Tech Talks</option>
                        <option name="category" value="workshops">Workshops</option>
                  </select>
                </div>


                <div class="form-group search-box">
                  <input name="search_term" id="search_box" type="text" class="form-control search" placeholder="Search"></input>
                  <button type="submit" class="btn btn-info search-btn form-control">
                    <span class="glyphicon glyphicon-search align-bottom"></span>
                    </button>
                </div>

              </form>
            </div>

            <!--buttons for sign up and log in-->
            <ul class="nav navbar-nav navbar-right">

              <!--new event button-->
              <li class="page-scroll">
                <a href="#" class="" data-toggle="modal" data-target="#new-event-modal" >
                  <span class="glyphicon glyphicon glyphicon-plus align-text-bottom"></span> Event
                </a>
              </li>

              <!--login button and login dropdown form-->
              <li class="dropdown page-scroll">
                <a href="#" id="login-btn" class="" data-toggle="modal" data-target="#login-modal">
                  <span class="glyphicon glyphicon-log-in"></span> Login
                </a>
              </li>

              <!--sign up button and drod down form-->
              <li class="page-scroll">
                <a href="#" class="" data-toggle="modal" data-target="#signup-modal">
                  <span class="glyphicon glyphicon-plus"></span> Sign Up
                </a>
              </li>

              <!-- Actions Menu -->
              <li class="page-scroll">
                <a href="#" id="dropdownActionButton" class="dropdown-toggle"  data-toggle="dropdown">
                  <span class="glyphicon glyphicon-th-large"></span>
                  <span class="caret"></span>
                </a>

                <!-- drop down buttons-->
                <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu" aria-labelledby="dropdownActionButton" >
                  <li>
                    <div class="col-lg-12">
                      <div class="text-center">
                        <h3><b>Sign Up</b></h3>
                        <hr class="colorgraph"><br>
                      </div>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
            <!--</ nav bar buttons>-->

          </div>
          <!--/.navbar-collapse -->

        </div>
        <!--</nav bar container>-->

      </nav>
      <!--/.navbar-->
            $body

      <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
      <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
          <i class="fa fa-chevron-up"></i>
        </a>
      </div>

     </div>
      <!--new event modal-->
      <div id="new-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="new-event-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <!--title-->
            <div class="modal-header">
              <h1 class="modal-title" id="new-event-label">Create a new event</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!--</modal-header>-->

            <!-- Content of the new event modal -->
            <div class="modal-body">
              <form class="new-event-form">
                 <div class="form-block">
                    <div class="left-form">
                      Event name <br>
                        <input type="text" name="eventname" placeholder="e.g. Free South Campus barbecue"><br>
                      Event day <br>
                        <input id="date" type="date"> <br>
                      Time <br>
                       From <input type="time" name="timefrom"> Till <input type="time" name="timetill"> <br>
                      Description <br>
                        <textarea name="Text1" cols="40" rows="5" placeholder="Give a description of your event here..."></textarea> <br>
                      Tickets required <br>
                        <input type="radio" name="ticketsrequired" value="yes"> Yes
                        <input type="radio" name="ticketsrequired" value="no"> No <br>
                      Price <br>
                        Free <input type="checkbox" name="free" value="free"> or $ <input type="number" min="0.00" max="10000.00" step="0.01"  placeholder="0.00"> <br>
                      Link to buy tickets: <br>
                        <input type="text" name="link" placeholder="e.g. buyyourtickershere.com/tickets"> <br>
                    </div>
                </div>
                <div id=rightformblock class="form-block">
                  <div class="right-form">
                    <h5>Optional: upload an event picture</h5> <br>
                      <input name="myFile" type="file"> <br>
                      <img src="imgs/placeholder.jpg">
                  </div>
                </div>
              </form>
            </div>
            <!--</modal-body>-->

            <!--footer-->
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <!--</modal-footer>-->

          </div>
          <!--</modal-content>-->

        </div>
        <!--</modal-dialog>-->

      </div>
      <!--</new-event-modal>-->



      <!--login modal -->
      <div id="login-modal" class="modal right fade" tabindex="-1" role="dialog" aria-labelledby="login-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <!--tile-->
            <div class="modal-header">
              <!--close button-->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <!--title and colorgram-->
              <div class="text-center">
                <h3 class="modal-title" id="login-label"><b>Login</b></h3>
                <hr class="colorgraph"><br>
              </div>
            </div>
            <!--</modal-header>-->

            <!--body -->
            <div class="modal-body">
              <div class="col-lg-12">

                <!--adds error mgs if login was unsuccessful-->

                <form id="login-form" action="res/login/process_login.php" method="post" autocomplete="off">

                  <!--user_avatar_default name input-->
                  <div class="form-group has-feedback">
                    <input type="email" name="email" id="login-email" tabindex="1" class="form-control" placeholder="Email" value="" autocomplete="off"  required>
                    <i class="form-control-feedback glyphicon glyphicon-user"></i>
                  </div>
                  <!--</user name input>-->

                  <!--password input-->
                  <div class="form-group has-feedback">
                    <input type="password" name="password" id="login-password" tabindex="1" class="form-control" placeholder="Password" autocomplete="off" required>
                     <i class="form-control-feedback glyphicon glyphicon-lock"></i>
                  </div>

                  <!--remember me option and submit button-->
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-7">
                        <input type="checkbox" tabindex="3" name="remember" id="remember">
                        <label for="remember"> Remember Me</label>
                      </div>
                      <div class="col-xs-5 pull-right">
                        <input type="submit" name="submit" id="login-submit" tabindex="4" class="form-control btn btn-success" value="Log In">
                      </div>
                    </div>
                  </div>

                  <!--forgot password link-->
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-center">
                          <a href="http://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" class="hide" name="token" id="login-token" value="a465a2791ae0bae853cf4bf485dbe1b6">

                </form>
              </div>
            </div>
            <!--</modal-body>-->

            <!--footer-->
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <!--</modal-footer>-->

          </div>
          <!--</modal-content>-->

        </div>
        <!--</modal-dialog>-->

      </div>
      <!--</login-modal>-->

      <!--signup modal-->
      <div id="signup-modal" class="modal fade right" tabindex="-1" role="dialog" aria-labelledby="signup-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <!--tile-->
            <div class="modal-header text-center">

              <!--close button-->
              <button id='signup-close' type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

              <!--title and colorgram-->
              <div class="text-center">
                <h3 class="modal-title" id="signup-label"><b>Sign Up</b></h3>
                <hr class="colorgraph"><br>
              </div>
            </div>
            <!--</modal-header>-->

            <!--body -->
            <div class="modal-body">
              <div class="col-lg-12">

                <form id="signup-form" action="res/signup/process_signup.php" method="post" autocomplete="off">

                  <div class="form-group text-center">
                    <img src="imgs/user_avatar_default.png" alt="User Avatar" id="signup-avatar" class="img-circle"></img><br>
                    <!--<label for="avatar-file">Avatar</label>-->
                    <!--<input type="file" id="avatar-file" class="form-control-file">-->
                      <label for="avatar-file" id="file-label" class="btn" style="border: solid 1px;"><i class="glyphicon glyphicon-upload"></i> Upload Avatar</label>
                      <input id="avatar-file" style="display:none;" type="file"></input>
                  </div>

                  <div class="form-group has-feedback">
                    <label for="firstname">Fisrt Name</label>
                    <input type="text" name="first-name" id="firstname" tabindex="1" class="form-control"
                           placeholder="First Name" value="" autocomplete="off" required onchange="refreshWarning(this);">
                  </div>

                  <div class="form-group has-feedback">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="last-name" id="lastname" tabindex="1" class="form-control"
                           placeholder="Last Name" value="" autocomplete="off" required onchange="refreshWarning(this);">
                  </div>

                  <div class="form-group has-feedback">
                    <label for="signup-email">Email</label>
                    <input type="email" name="email" id="signup-email" tabindex="1" class="form-control" placeholder="Last Name" value="" autocomplete="off" required>
                  </div>

                  <p class="error" id="pass_error"></p>
                  <div class="form-group">
                    <label for="signup-password">New Password</label>
                    <input type="password" name="password" id="signup-password" tabindex="2" class="form-control"
                           placeholder="New Password" autocomplete="off" required onchange="refreshWarning(this);"
                           data-placement="bottom" title="Passwords must have more than 8 digits." >
                  </div>

                  <div class="form-group">
                    <label for="re-signup-password">Re-enter New Password</label>
                    <input type="password" name="re-password" id="signup-repassword" tabindex="2" class="form-control"
                           placeholder="Re-Password" autocomplete="off" required onchange="refreshWarning(this);">
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-7 pull-right">
                        <input type="submit" name="signup-submit" id="signup-submit" tabindex="4" class="form-control btn btn-success" value="Create Acount">
                      </div>
                      <div class="col-xs-5 pull-right">
                        <input type="reset" name="signup-reset" id="signup-reset" tabindex="4" class="form-control btn btn-success" value="Reset">
                      </div>

                    </div>
                  </div>

                </form>
              </div>
            </div>
            <!--</modal-body>-->

          </div>
          <!--</modal-content>-->

        </div>
        <!--</modal-dialog>-->

      </div>
      <!--</signup-modal>-->


    <div class="navbar navbar-fixed-bottom" id="footer">
        <!-- Footer -->
          <footer class="text-center">

            <div class="">
              <div class="row">
                <div class="col-lg-12">
                  Copyright &copy; Activities Hub 2017
                </div>
              </div>
            </div>

          </footer>
        </div>



    <!--script that handles updating avatar image and uplaod button-->
    <script src="res/signup/upload_avatar.js"></script>
    <!--script that handles updating avatar image and uplaod button-->
    <script src="res/signup/validate_signup.js"></script>
    <script src="res/events/search_results.js"></script>
  </body>
</html>
EOPAGE;

        return $page;
    }

?>
