function goToEventSearchResults(id) {
      console.log("ID = " + id);

      $('#search-category-block').val(id);

      document.getElementById("search-form").submit();
}

function setSearchCategoryOptions(category) {
      $("#" + category + "-category").prop('selected', true);
}
