//makes all toll tips activated
$(document).ready(function(){
    $('input').tooltip();
});

function compare_passwords(password) {

    //get other password
    let repassword =  document.getElementById("signup-repassword");
    let repassword_val = repassword.value;

    //trigger a change in the second password in case the first was changed after the second
    if(repassword_val !== ""){
        $(repassword).change();
    }

    $(repassword).change(function () {
        let repassword_val = repassword.value;
        let password_val =  password.value;

        if(password_val !== repassword_val && repassword_val !== ""){
            document.getElementById("pass_error").innerHTML = "<h4>Passwords Don't Match.</h4>";
        } else {
            document.getElementById("pass_error").innerHTML = "";
        }
    });
}

function validate_password(password) {
    return (password !== "" && password !== " " && password.length() > 8);
}

function validate_input(){

}