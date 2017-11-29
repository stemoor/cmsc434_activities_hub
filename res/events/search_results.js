function goToEventSearchResults(id) {
      console.log("ID = " + id);

      $('#search-category-block').val(id);

      document.getElementById("search-form").submit();
}

function setSearchCategoryOptions(category) {
      $("#" + category + "-category").prop('selected', true);
}

//$("#techtalk-btn").click(function() {
//  document.getElementById("event2").style.display = "none";
//  document.getElementById("event3").style.display = "none";
//  document.getElementById("event4").style.display =  null;
//  document.getElementById("event5").style.display =  null;
//  let plus_icon = "<i class='list-icon glyphicon glyphicon-plus'></i>";
//
//  let minus_icon = "<i class='list-icon glyphicon glyphicon-minus'></i>";
//
//  document.getElementById("all-categories-btn").innerHTML  = plus_icon + 'All Categories';
//  document.getElementById("clubs-btn").innerHTML  = plus_icon + 'Club Meetings';
//  document.getElementById("workshops-btn").innerHTML  = plus_icon + 'Workshops';
//  document.getElementById("techtalk-btn").innerHTML  = minus_icon + 'Tech Talks';


//});