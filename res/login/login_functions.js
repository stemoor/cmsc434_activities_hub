function toggle_control_buttons(on){
    if(on){
        document.getElementById("account-btn").style.display = "inherit";
        document.getElementById("login-btn").style.display = "none";
        document.getElementById("logout-btn").style.display = "inherit";
        document.getElementById("signup-btn").style.display = "none";

    }else {
        document.getElementById("account-btn").style.display = "none";
        document.getElementById("login-btn").style.display = "inherit";
        document.getElementById("logout-btn").style.display = "none";
        document.getElementById("signup-btn").style.display = "inherit";
    }
}

function toggle_planner_features(on){
     var features = document.getElementsByClassName("planner_features");

    if(on){
       for( i =0; i < features.length; i++){
            features[i].style.display = "inherit";
       }

    } else {

        for( i =0; i < features.length; i++){
            features[i].style.display = "none";
       }
    }
}

function toggle_basic_user_features(on){
    var features = document.getElementsByClassName("basic_user_features");

    if(on){
        for( i =0; i < features.length; i++){
            features[i].style.display = "inherit";
       }

    } else {

         for( i =0; i < features.length; i++){
            features[i].style.display = "none";
       }
    }
}

function update_account_modal(isPlanner){
    if(isPlanner){
        toggle_planner_features(true);
        toggle_basic_user_features(false);
    } else {
        toggle_planner_features(false);
        toggle_basic_user_features(true);
    }
}

function close_account_modal(){
    $('#account-close').click();
}

function ask_to_login(){
    res = confirm("You must be logged . Login?");

    if(res){
        $('#login-btn').click();
    } 
}