<?php
    include_once "res/db/db_connect.php";
    include_once "res/db/functions.php";

    sec_session_start();

    $logged_in = false;
    $user_name = "";
    $is_planner = false;

    //check if logged in
    if(login_check($db_connection) === true) {
        $logged_in = true;
        $user_name = $_SESSION['user_name'];
        $is_planner = $_SESSION['is_planner'];

        echo "<script>console.log('$user_name logged in');</script>";
    } else {
        $logged_in = false;
        echo "<script>console.log('not logged in');</script>";
    }

    function generate_page($body, $page) {
        global $user_name;
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

     <script src="res/events/search_results.js"></script>
     <script src="res/login/login_functions.js"></script>

    <!-- Custom styles for this page -->
    <link href="css/main_style.css" rel="stylesheet">
    <link href="css/event_search_results_style.css" rel="stylesheet">

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
            <div class="nav-search-field">
              <form action="search_results.php" method="POST" class="navbar-form navbar-left">
                <div class="form-group">
                    <select  name="category" id="search_category" class="search form-control">
                        <option id="all-events-category" value="all-events">All</option>
                        <option id="club-category" value="club">Club</option>
                        <option id="techtalk-category" value="techtalk">Tech Talks</option>
                        <option id="workshop-category" value="workshop">Workshops</option>
                        <option id="other-category" value="other">Workshops</option>
                        <option id="organization-category" value="organization">Organization</option>

                    </select>
                  <input name="search_term" id="search_box" type="text" class="form-control search" placeholder="Search"></input>
                  <button type="submit" name="submit" class="btn btn-info search-btn form-control dark-purple-bg">
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
                <a href="#" id="account-btn" class="account-nav-btn" data-toggle="modal" data-target="#account-modal" style="display:none;">
                  <!-- <span class="glyphicon glyphicon-th-large"></span> Account -->
                   <img alt="Brand" class="img-circle" src="imgs/user_avatar_default.png"> &nbsp;Hi, $user_name!
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

EOPAGE;
            if($logged_in){
                $body_top .= '<script>toggle_control_buttons(true);</script>';

            } else {
                $body_top .= '<script>toggle_control_buttons(false);</script>';
            }


    $body_top .= <<<EOPAGE


            $body


      <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
      <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
          <i class="fa fa-chevron-up"></i>
        </a>
      </div>

     </div>
      <!--new event modal-->
      <div id="new-event-modal" class="modal fade dark-overlay-bg " tabindex="-1" role="dialog" aria-labelledby="new-event-label" aria-hidden="true">
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

                <form id="signup-form" action="res/signup/process_signup.php" method="post" autocomplete="off">

                  <div class="form-group text-center">
                    <img src="imgs/user_avatar_default.png" alt="User Avatar" id="signup-avatar" class="img-circle" ></img><br>
                    <!--<label for="avatar-file">Avatar</label>-->
                    <!--<input type="file" id="avatar-file" class="form-control-file">-->
                    <p id="load-avatar-error" class="error" style="color:red;"></p>
                      <label for="avatar-file" id="file-label" class="btn drop-right-shadow green-bg" ><i class="glyphicon glyphicon-upload"></i> Upload Avatar: .jpg, .png</label>
                      <input id="avatar-file" name="avatar-file" style="display:none;" type="file"></input>
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
                    <input type="checkbox" name="planner" id="planner" tabindex="2" class="borderless" value="yes"
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
          <div class="modal-content black-bg">
            <!--tile-->
            <div class="modal-header text-center">
              <!--close button-->
              <button id='account-close' type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <!--title and colorgram-->
              <div class="text-center">
                <h2 class="modal-title" id="saccount-label">  $user_name   </h2>
                <hr class="colorgraph"><br>
              </div>
            </div>
            <!--</modal-header>-->
            <!--body -->
            <div class=" text-center">
              <div class="col-lg-12 modal-body">
                <div class="account-modal-body">
                    <img src="imgs/user_avatar_default.png" alt="User Avatar" id="signup-avatar" class="img-circle"></img><br>
                </div>
                <div class="text-center account-side-panel-nav">
                  <ul class="nav flex-column">
                    <li class="nav-item" onclick="goToEventSearchResults('all-events')">
                      <a id="" class="nav-link" href="#">
                        <i class="list-side-panel-icon glyphicon glyphicon-minus"></i>My Account
                      </a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('workshop')">
                      <a id="" class="nav-link" href="#">
                        <i class="list-side-panel-icon glyphicon glyphicon-minus"></i>Events I am going!
                      </a>
                    </li>
                    <li class="nav-item" onclick="goToEventSearchResults('techtalk')">
                      <a id="" class=" nav-link " href="#">
                        <i class="list-side-panel-icon glyphicon glyphicon-minus"></i>Favorited Events
                      </a>
                    </li>
                  </ul>
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