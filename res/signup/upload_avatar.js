//listener for loading the avatar picture
$('#avatar-file').on('change', function(){
    alert();
    //get the avatar path
    var filename = document.getElementById("avatar-file").value;
    //get the name from the path
    var last_slash = filename.lastIndexOf("\\");
    filename = filename.substr(last_slash + 1);

    //if user selected a picture
    if(filename !== "") {
        //change the upload button text to show the selected file name and load the picture
        document.getElementById('file-label').innerHTML = "<i class='glyphicon glyphicon-upload'></i><strong> upload: </strong> " + filename;
        load_avatar(this);
    }
});

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