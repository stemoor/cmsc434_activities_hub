function goToEventSearchResults(id) {

      $('#search-category-block').val(id);
      document.getElementById("search-form").submit();
}

function update_search_box(term, category){
        document.getElementById('search_box').value = term;
        document.getElementById(category + "-category").selected = 'selected';
}

function update_search_categories(id){

      id = id + '-btn';
      categories = document.getElementsByClassName('list-side-panel-icon');

      for(i = 0; i < categories.length; i++){

            if(categories[i].parentNode.id !== id){
                  categories[i].className = "list-side-panel-icon glyphicon glyphicon-minus";
            } else{
                  categories[i].className = "list-side-panel-icon glyphicon glyphicon-plus";
            }

      }

}

function ask_to_login(){
    res = confirm("You must be logged to complete this action. Do you want to Login?");

    if(res){
        $('#login-btn').click();
    }
}
