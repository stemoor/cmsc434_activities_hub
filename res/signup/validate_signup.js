//makes all toll tips activated
$(document).ready(function(){
    $('input').tooltip();
});

document.getElementById("signup-form").onsubmit = validate_input;

function compare_passwords(password, confirm_password) {

    if(password.value !== confirm_password.value) {
        console.log("don't match p: " + password + " rep: " + confirm_password);
        confirm_password.setCustomValidity("Passwords don't match.");
        return false;
    } else {
        console.log("match");
        confirm_password.setCustomValidity("");
        return true;
    }

}

function validate_password(password) {

    let val = password.value.trim();

    if(val === "") {
        password.setCustomValidity("Password can't be empty space.");
        return false;
    } else if (val.length < 8) {
        password.setCustomValidity("Password must contain at least 8 (non-empty space) characters.");
        return false;
    }

    password.setCustomValidity("");
    return true;
}

function validate_name(name){
    if(name.value === " ") {
        name.setCustomValidity("Insert a valid name.");
        return false;
    } else {
        name.setCustomValidity("");
        return true;
    }
}

function validate_input(){

    let first_name = document.getElementById("firstname");
    let last_name = document.getElementById("lastname");
    let password = document.getElementById("signup-password");
    let confirm_password = document.getElementById("signup-repassword");

    if(!validate_name(first_name) || !validate_name(last_name) || !validate_password(password) || !compare_passwords(password, confirm_password) ) {
        return false;
    }

    //if everything is good, prompt user for rest of info
    
    return true;

}

function refreshWarning(input){
    input.setCustomValidity("");
}