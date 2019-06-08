/*
function onScroll(e)
{
  alert("scrolled");
}*/

function addListeners()
{
  document.getElementById("simple_search_button").addEventListener("click", fetchImagesSimpleSearch);
  document.getElementById("btn_search").addEventListener("click", fetchImagesAdvancedSearch);
  document.getElementById("adv_search_1").addEventListener("click", toggleAdvSearch);
  document.getElementById("adv_search_2").addEventListener("click", toggleAdvSearch);
  document.getElementById("search_box").setAttribute("onKeyPress", "if (event.which == 13) fetchImagesSimpleSearch();");
  //document.getElementById("image_display").addEventListener("scroll", onScroll);
}

emptySearchQuery();
addListeners();
fetchAllImages();

