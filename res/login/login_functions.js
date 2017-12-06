function toggle_control_buttons(signedIn){
    if(signedIn){
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

