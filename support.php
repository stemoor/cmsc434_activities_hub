<?php
    include_once "res/db/db_connect.php";
    include_once "res/db/functions.php";

    sec_session_start();

    $logged_in = false;
    $user_name = "";
    $is_planner = false;
    $avatar = "imgs/user_avatar_default.png"; //regulat default avatar

    //check if logged in
    if(login_check($db_connection) === true) {
        $logged_in = true;
        $user_name = ucfirst($_SESSION['user_name']);
        $is_planner = $_SESSION['is_planner'];

        //retrieve avatar stored in db
        $db_avatar = get_user_avatar($db_connection, $_SESSION['user_id']);

        //check if value returned is not null, if so, display picture
        if($db_avatar !== null){
            $avatar = "data:image/png;base64," . base64_encode(get_user_avatar($db_connection, $_SESSION['user_id']));
        }

        if(isset($_SESSION['action_completed'])){
              echo "<script>alert('".$_SESSION['action_completed']."');</script>";
              unset($_SESSION['action_completed']);
        }

        echo "<script>console.log('$user_name logged in');</script>";
    } else {
        $logged_in = false;
        echo "<script>console.log('not logged in');</script>";
    }

    function generate_page($body, $page) {
        global $user_name;
        global $logged_in;
        global  $is_planner;
        global $avatar;
        global $logged_in;
        $head = <<<EOPAGE

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="imgs/brand_logo.png">

    <title>Activity Hub</title>

    <!--Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

     <script src="res/events/search_results.js"></script>
     <script src="res/login/login_functions.js"></script>

    <!-- Custom styles for this page -->
    <link href="css/main_style.css" rel="stylesheet">
    <link href="css/event_search_results_style.css" rel="stylesheet">
    <link href="css/my_events_style.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300|Raleway:300|Roboto:100" rel="stylesheet">
  </head>
EOPAGE;

    //check error messages
    $error_msg[1] = "";
    $error_msg[2] = "";
            if(isset($_GET['error'])){
                if($_GET['error'] == 1){
                    $error_msg[1] = "Invalid account information!";
                } else if($_GET['error'] == 2) {
                    $error_msg[2]= "Email already linked to another account";

                }
                unset($_GET['error']);
            }

    $body_top = <<<EOPAGE
  <body>


    <div id="$page" class="page-wrapper">
      <!--navigation bar-->
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-wrapper container ">
          <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
              <img alt="Brand" src="imgs/brand_logo.png">
            </a>

            <!-- menu button for when navigation bar is collapsed for mobile-->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <!--title of the page-->
            <a class="navbar-brand navbar-left" href="index.php">Activity Hub</a>
          </div>

          <!--add every nav bar button/link under here so it can be collapsed for mobal-->
          <div id="navbar" class="navbar-collapse collapse align-bottom">

            <!--home button-->
            <ul class="nav navbar-nav navbar-left">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="index.php#about">About</a></li>
            </ul>

            <!--search bar-->
            <div class="nav-search-field">
              <form action="search_results.php" method="POST" class="navbar-form navbar-left">
                <div class="form-group">
                    <select  name="category" id="search_category" class="search form-control">
                        <option id="all-events-category" value="all-events">All</option>
                        <option id="club-category" value="club">Club</option>
                        <option id="techtalk-category" value="techtalk">Tech Talks</option>
                        <option id="workshop-category" value="workshop">Workshops</option>
                        <option id="other-category" value="other">Other</option>
                        <option id="organization-category" value="organization">Organization</option>

                    </select>
                  <input name="search_term" id="search_box" type="text" class="form-control search" placeholder="Search"></input>
                  <button type="submit" name="search-bar-submit" class="btn btn-info search-btn form-control dark-purple-bg">
                    <span class="glyphicon glyphicon-search align-bottom"></span>
                  </button>

                </div>
              </form>
            </div>

            <!--buttons for sign up and log in-->
            <ul class="nav navbar-nav navbar-right">



              <!--login button-->
              <li class="dropdown page-scroll">
                <a href="#" id="login-btn" class="" data-toggle="modal" data-target="#login-modal">
                  <span class="glyphicon glyphicon-log-in"></span> Login
                </a>
              </li>


              <!--sign up button-->
              <li class="page-scroll">
                <a href="#" class="" id="signup-btn" data-toggle="modal" data-target="#signup-modal">
                  <span class="glyphicon glyphicon-plus"></span> Sign Up
                </a>
              </li>
              <!-- Account panel -->

              <!--account panel-->
              <li class="page-scroll">
                <a href="#" id="account-btn" class="account-nav-btn" data-toggle="modal" data-target="#account-modal" style="display:none;" onclick="update_account_modal($is_planner);">
                  <!-- <span class="glyphicon glyphicon-th-large"></span> Account -->
                   <img alt="Brand" class="img-circle" src="$avatar"> &nbsp;Hi, $user_name!
                </a>
              </li>
            <!-- Account Menu -->

            <!--logout button-->
              <li class="dropdown page-scroll">

                <a href="#" id="logout-btn" class="" onclick="logout()">
                  <span class="glyphicon glyphicon-log-out"></span> Logout
                </a>

                <form id="logout-form" action="res/logout/process_logout.php" method="POST" style="display:none;">
                    <input type="hidden" name="logout">
                </form>
              </li>

              <script>

                function logout(){

                      var res = confirm("Are you sure you sure you want to logout?");
                      if(res){
                            document.getElementById("logout-form").submit();
                      }
                }
             </script>

             </ul>
            <!--</ nav bar buttons>-->

          </div>
          <!--/.navbar-collapse -->

        </div>
        <!--</nav bar container>-->

      </nav>
      <!--/.navbar-->

        $body


EOPAGE;
            //check if user is logged in
            if($logged_in){
                $body_top .= '<script>toggle_control_buttons(true);</script>';

                //if logged in and a planner, turn on planner only features
                if($is_planner) {
                    $body_top .= '<script>toggle_planner_features(true);</script>';
                    $body_top .= '<script>toggle_basic_user_features(false);</script>';
                } else {
                    $body_top .= '<script>toggle_planner_features(false);</script>';
                    $body_top .= '<script>toggle_basic_user_features(true);</script>';
                }

            } else {
                $body_top .= '<script>toggle_control_buttons(false);</script>';
                $body_top .= '<script>toggle_planner_features(false);</script>';
            }

            if(isset($_SESSION['event_created'])){
                if( $_SESSION['event_created']){
                    $body_top .= '<script>alert("Event Created Successfully!");</script>';
                } else {
                    $body_top .= '<script>alert("Opps, something went wrong with creating event. Try again later!");</script>';
                }

                unset($_SESSION['event_created']);

            }


    $body_top .= <<<EOPAGE

      <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
      <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
          <i class="fa fa-chevron-up"></i>
        </a>
      </div>

     </div>
      <!--new event modal-->
      <div id="new-event-modal" class="modal right fade dark-overlay-bg " tabindex="-1" role="dialog" aria-labelledby="new-event-label" aria-hidden="true">
        <div id="new-event-dialog" class="modal-dialog modal-lg">
          <div class="modal-content">
            <!--tile-->
            <div class="modal-header">
              <!--close button-->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <!--title and colorgram-->
              <div class="text-center ">
                <h2 class="modal-title" id="new-event-title">Create New Event!</h2>
                <hr class="colorgraph"><br>
              </div>
            </div>
            <!--</modal-header>-->

            <!-- Content of the new event modal -->
            <div class="modal-body">
              <form class="new-event-form" action="res/events/process_add_event.php" method="POST" enctype="multipart/form-data">
                 <div class="row">
                    <div class="col-sm-6">

                        <div class="form-container">


                            <div class="form-group">
                                <label for="new-event-category">Pick Event Catergory </label>
                                <select  name="new-event-category" id="new-event-category" class="search form-control">
                                    <option id="" value="club">Club Meeting</option>
                                    <option id="" value="techtalk">Tech Talks</option>
                                    <option id="" value="workshop">Workshops</option>
                                    <option id="" value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="event_name">Event name</label>
                                <input type="text" name="event_name" id="event_name" tabindex="1" class="form-control drop-right-shadow" placeholder="e.g. Free South Campus barbecue" required>
                            </div>

                             <div class="form-group ">
                                <label for="location">Location</label>
                                <input type="text" name="location" id="location" tabindex="1" class="form-control drop-right-shadow"
                                    placeholder="e.g. A.V Williams Room #1254" required>
                            </div>


                            <div class="form-group ">
                                <label for="start-datetime">Start Date and Time</label>
                                <input  id="start-datetime" type="datetime-local" name="start-datetime" tabindex="1" class="form-control drop-right-shadow" required>
                            </div>


                            <div class="form-group ">
                                <label for="end-datetime">End Date and Time</label>
                                <input  id="end-datetime" type="datetime-local" name="end-datetime" tabindex="1" class="form-control drop-right-shadow" required>
                            </div>

                            <div class="form-group ">
                                <label for="event_pic">Upload a picture (optional)</label>
                                <input id="event_pic" name="event_pic" class="form-control drop-right-shadow"  type="file">
                            </div>

                            <div class="important">
                                <div class="form-group ">
                                    <label for="publish">Publish this event?</label> <br>
                                    <input id="publish" name="publish" class="drop-right-shadow"  type="radio" value="true" required> Yes!
                                    <input id="publish" name="publish" class="drop-right-shadow"  type="radio" value="false" required> No, save for later!
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- end of left side of grid -->


                   <div class="col-sm-6">
                        <div class="form-container">

                              <div class="form-group ">
                                  <label for="description">Event Description</label>
                                  <textarea id="description" name="description" cols="40" rows="5" placeholder="Add additional description of the event here..."
                                  class="form-control drop-right-shadow" required></textarea>
                             </div>

                        </div>
                 </div>
                  <!-- end of right side of grid -->

                </div>
                <!-- end of row -->

                <div class="row">

                    <div class="footer col-sm-12">
                        <div class="event-footer form-group">
                            <input type="submit" name="new-event-submit" id="new-event-submit" tabindex="4" class="form-control btn btn-success drop-right-shadow green-bg" value="Create New Event">
                        </div>
                    </div>
                </div>


              </form>
            </div>
            <!--</modal-body>-->

          </div>
          <!--</modal-content>-->

        </div>
        <!--</modal-dialog>-->

      </div>
      <!--</new-event-modal>-->



      <!--login modal -->
      <div id="login-modal" class="modal right fade dark-overlay-bg " tabindex="-1" role="dialog" aria-labelledby="login-label" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
          <div class="modal-content teal-bg">

            <!--tile-->
            <div class="modal-header">
              <!--close button-->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <!--title and colorgram-->
              <div class="text-center ">
                <h2 class="modal-title" id="login-label">Login</h2>
                <hr class="colorgraph"><br>
              </div>
            </div>
            <!--</modal-header>-->

            <!--body -->
            <div class="modal-body">
              <div class="col-lg-12">

                <form id="login-form" action="res/login/process_login.php" method="post" autocomplete="off">


                <p id="login_error" class="error" style="color:red;">{$error_msg[1]}</p>

                  <div class="form-group has-feedback">
                    <input type="email" name="email" id="login-email" tabindex="1" class="form-control drop-right-shadow" placeholder="Email" value="" autocomplete="off"  required>
                    <i class="form-control-feedback glyphicon glyphicon-user"></i>
                  </div>
                  <!--</user name input>-->

                  <!--password input-->
                  <div class="form-group has-feedback">
                    <input type="password" name="password" id="login-password" tabindex="1" class="form-control drop-right-shadow" placeholder="Password" autocomplete="off" required>
                     <i class="form-control-feedback glyphicon glyphicon-lock"></i>
                  </div>

                  <!--remember me option and submit button-->
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 text-center">
                        <input type="submit" name="submit" id="login-submit" tabindex="4" class="form-control btn btn-success green-bg drop-right-shadow" value="Log In">
                      </div>
                    </div>
                  </div>

                </form>
              </div>
            </div>
            <!--</modal-body>-->

            <!--footer
            <div class="modal-footer">
            </div>
           </modal-footer>-->

          </div>
          <!--</modal-content>-->

        </div>
        <!--</modal-dialog>-->

      </div>
      <!--</login-modal>-->

      <!--signup modal-->
      <div id="signup-modal" class="modal fade right dark-overlay-bg " tabindex="-1" role="dialog" aria-labelledby="signup-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content light-purple-bg">

            <!--tile-->
            <div class="modal-header text-center">

              <!--close button-->
              <button id='signup-close' type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

              <!--title and colorgram-->
              <div class="text-center">
                <h2 class="modal-title" id="signup-label">Sign Up</h2>
                <hr class="colorgraph"><br>
              </div>
            </div>
            <!--</modal-header>-->

            <!--body -->
            <div class="modal-body">
              <div class="col-lg-12">

                <form id="signup-form" action="res/signup/process_signup.php" method="post" autocomplete="off" enctype="multipart/form-data">

                  <div class="form-group text-center">

                    <img src="imgs/user_avatar_default.png" alt="User Avatar" id="signup-avatar" class="img-circle" ></img><br>

                    <p id="load-avatar-error" class="error" style="color:red;"></p>

                      <label for="avatar-file" id="file-label" class="btn drop-right-shadow green-bg" ><i class="glyphicon glyphicon-upload"></i> Upload Avatar: .jpg, .png</label>
                      <input id="avatar-file" name="avatar" style="display:none;" type="file"></input>
                  </div>

                  <div class="form-group has-feedback">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" tabindex="1" class="form-control borderless drop-right-shadow"
                           placeholder="First Name" value="" autocomplete="off" required onchange="refreshWarning(this);">
                  </div>

                  <div class="form-group has-feedback">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" tabindex="1" class="form-control borderless drop-right-shadow"
                           placeholder="Last Name" value="" autocomplete="off" required onchange="refreshWarning(this);">
                  </div>

                   <p id="error_2" class="error" style="color:red;">{$error_msg[2]}</p>

                  <div class="form-group has-feedback">
                    <label for="signup-email">Email</label>
                    <input type="email" name="email" id="signup-email" tabindex="1" class="form-control drop-right-shadow borderless" placeholder="Email" value="" autocomplete="off" required>
                  </div>

                  <p class="error" id="pass_error"></p>
                  <div class="form-group">
                    <label for="signup-password">New Password</label>
                    <input type="password" name="password" id="signup-password" tabindex="2" class="form-control drop-right-shadow borderless"
                           placeholder="New Password" autocomplete="off" required onchange="refreshWarning(this);"
                           data-placement="top" title="Password must have more than 8 digits." >
                  </div>

                  <div class="form-group">
                    <label for="re-signup-password">Re-enter New Password</label>
                    <input type="password" name="repassword" id="signup-repassword" tabindex="2" class="form-control borderless drop-right-shadow"
                           placeholder="Re-Password" autocomplete="off" required onchange="refreshWarning(this);">
                  </div>

                 <div class="form-group">
                    <input type="checkbox" name="planner" id="planner" tabindex="2" class="borderless" value="true"
                            data-toggle="collapse" data-target="#organization-info"
                            onchange="refreshWarning(this);" onclick="appendSignupForm(this)">
                            <span class="formatted-text"> Get veryfied as a UMD afiliated organization</span>
                </div>

                <div id="organization-info" class="formatted-text  collapse">

                    <div class="form-group has-feedback">
                      <label for="organization">Organization Name</label>
                      <input type="text" name="organization" id="organization" tabindex="1" class="organization-info-inner form-control borderless drop-right-shadow"
                             placeholder="Organization Name" value="" autocomplete="off">
                    </div>

                    <div class="form-group has-feedback">
                      <label for="country_code">Phone Number</label><br>
                      <input type="text" name="country_code" id="country_code" tabindex="1" class="phone organization-info-inner form-control borderless drop-right-shadow"
                             size="2" autocomplete="off"  placeholder="+1" maxlength="2" minlength="1">
                      <input type="text" name="number_1" id="number_1" tabindex="1" class="phone organization-info-inner form-control borderless drop-right-shadow"
                             size="3" autocomplete="off" maxlength="3" minlength="3">
                      <input type="text" name="number_2" id="number_2" tabindex="1" class="phone organization-info-inner form-control borderless drop-right-shadow"
                             size="3" autocomplete="off" maxlength="3" minlength="3">
                      <input type="text" name="number_3" id="number_3" tabindex="1" class="phone organization-info-inner form-control borderless drop-right-shadow"
                             size="4" autocomplete="off" maxlength="4" minlength="4">
                    </div>

                    <div class="form-group has-feedback">
                      <label for="website">Organization Website</label>
                      <input type="url" name="website" id="website" tabindex="1" class="form-control borderless drop-right-shadow organization-info-inner"
                             placeholder="url" value="" autocomplete="off">
                    </div>

                    <p>To be approved as a UMD affiliated organization, this account must be for either for a UMD department, official club, student organization, or sponsors. </p>
                 </div>

                  <script>
                    function appendSignupForm(checkbox){
                        var body = document.getElementById('organization-info-inner');
                        if(checkbox.checked){

                            $('.organization-info-inner').prop('required', true);
                        } else {
                            $('.organization-info-inner').prop('required', false);
                        }
                    }
                  </script>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-7 pull-right">
                        <input type="submit" name="signup-submit" id="signup-submit" tabindex="4" class="form-control btn btn-success drop-right-shadow green-bg" value="Create Acount">
                      </div>
                      <div class="col-xs-5 pull-right">
                        <input type="reset" name="signup-reset" id="signup-reset" tabindex="4" class="form-control btn btn-success drop-right-shadow green-bg"  value="Clear">
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


     <!--<!--account modal-->
      <div id="account-modal" class="no-overlay-bg modal fade right in" tabindex="-1" role="dialog" aria-labelledby="account-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content dark-gray-bg">
            <!--tile-->
            <div class="modal-header text-center">
              <!--close button-->
              <button id='account-close' type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <!--title and colorgram-->
              <div class="text-center">
                <h2 class="modal-title" id="saccount-label">Hi,  $user_name   </h2>
                <hr class="colorgraph"><br>
              </div>
            </div>
            <!--</modal-header>-->
            <!--body -->
            <div class=" text-center">
              <div class="col-lg-12 modal-body">
                <div class="account-modal-body">
                    <img src="$avatar" alt="User Avatar" id="signup-avatar" class="img-circle drop-right-shadow"></img><br>
                </div>
                <div class="text-center account-side-panel-nav">
                  <ul class="nav flex-column">

                    <li class="nav-item">
                      <a id="" class="nav-link" href="#">
                        <i class="acc-modal-icon glyphicon glyphicon-user"></i>My Account
                      </a>
                    </li>

                    <!--new event button-->
                    <li class="nav-item ">
                      <a id="new_event-btn" href="#" class="nav-link planner_features" data-toggle="modal" data-target="#new-event-modal" onclick="close_account_modal()">
                        <i class="acc-modal-icon  glyphicon glyphicon glyphicon-plus align-text-bottom"></i> New Event
                      </a>
                    </li>

                    <!--published events button-->
                    <li class="nav-item" >
                      <a id="published_events"  class="nav-link planner_features" href="#" class="nav-link">
                        <i class="acc-modal-icon  glyphicon glyphicon-send align-text-bottom"></i> Published Events
                      </a>
                    </li>

                    <!--saved events button-->
                    <li  class="nav-item" >
                      <a id="saved_events" href="#" class="nav-link planner_features" >
                        <i class="acc-modal-icon  glyphicon glyphicon-floppy-disk align-text-bottom"></i> Saved Events
                      </a>
                    </li>

                    <li id="" class="nav-item basic_user_features">
                      <a  class="nav-link" href="my_events.php?rsvp=true">
                        <i class="acc-modal-icon  glyphicon glyphicon-check"></i>RSVP'd Events
                      </a>
                    </li>

                    <li class="nav-item basic_user_features">
                      <a id="" class=" nav-link " href="my_events.php?rsvp=false">
                        <i class="acc-modal-icon  glyphicon glyphicon-star"></i>Favorite Events
                      </a>
                    </li>

                  </ul>


                    <form id="user-events-form" action="my_events.php" method="POST" style="display:none;">
                        <input type="hidden">
                    </form>
                </div>
              </div>
            </div>
            <!--</modal-body>-->
          </div>
          <!--</modal-content>-->
        </div>
        <!--</modal-dialog>-->
      </div>
      <!--</account-modal>-->

    <!--script that handles updating avatar image and uplaod button-->
    <script src="res/signup/validate_signup.js"></script>
    <!--script that handles updating avatar image and uplaod button-->
    <script src="res/signup/upload_avatar.js"></script>


    <script>
        var val = document.getElementById('login_error').innerHTML;
        if(val !== ""){
            $('#login-btn').click();
        }

        var val = document.getElementById('error_2').innerHTML;
        if(val !== ""){
            $('#signup-btn').click();
        }




    </script>


  </body>

</html>
EOPAGE;
        return $head.$body_top;
    }

?>