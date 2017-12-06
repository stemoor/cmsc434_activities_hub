//listener for loading the avatar picture
$('#avatar-file').on('change', update_signup_avatar);

$('#signup-avatar').on('click', function(){
    $('#avatar-file').click();
});

function update_signup_avatar(){

     //get the avatar path
    var filename = document.getElementById("avatar-file").value;
    //get the name from the path
    var last_slash = filename.lastIndexOf("\\");

    filename = filename.substr(last_slash + 1).trim();

    //if user selected a picture
    if(filename !== "" && (filename.endsWith(".png") || filename.endsWith(".jpg"))) {

        //reset the error
        document.getElementById('load-avatar-error').innerHTML = "";

        //change the upload button text to show the selected file name and load the picture
        document.getElementById('file-label').innerHTML = "<i class='glyphicon glyphicon-upload'></i><strong> upload: </strong> " + filename;

        //load the picture
        load_avatar(this);

    } else {

        //display file exentsion error
        document.getElementById('load-avatar-error').innerHTML = "Invalid format. Upload a .jpg or a .png file.";

        //update button text to filename
        document.getElementById('file-label').innerHTML = "<i class='glyphicon glyphicon-upload'></i><strong> Upload Avatar: .jpg or.png </strong> ";

        //laod the picture on signup modal
         load_default_avatar();
    }
}

function load_default_avatar(){
    $('#signup-avatar').attr('src', 'imgs/user_avatar_default.png');
}

//this functions reads and input file and loads it in the sign up modal in place of the default
function load_avatar(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
          $('#signup-avatar').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}


$('#signup-close').click(function(){
    restore_defautlt_avatar();
});

$('#signup-cancel').click(function(){
    restore_defautlt_avatar();
});

//this functions reads and input file and loads it in the sign up modal in place of the default
function load_avatar(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
          $('#signup-avatar').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function restore_defautlt_avatar(){
    $('#signup-avatar').attr('src', "../../imgs/user_avatar_default.png");
    document.getElementById('file-label').innerHTML = "<i class='glyphicon glyphicon-upload'></i> Upload Avatar";
}