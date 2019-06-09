const api_link = "/php/api/getimgs.php";
const FETCH_SIZE = 5;

var searchQuery;

function emptySearchQuery()
{
 searchQuery = {
   search: "",
   tags: "",
   date_bgn: "",
   date_end: "",
   min_size: "",
   max_size: "",
   min_width: "",
   max_width: "",
   min_height: "",
   max_height: "",
   user: "",
   limit: FETCH_SIZE,
   offset: 0
  };
}

function updateSearchQuery()
{
  searchQuery.offset += FETCH_SIZE;
}

function buildSimpleSearchQuery()
{
  search_input = document.getElementById("search_box");
  if (search_input.checkValidity())
    searchQuery.search = search_input.value;
}

function buildAdvancedSearchQuery()
{
  buildSimpleSearchQuery();

  tags_input = document.getElementById("tags_search");
  if (tags_input.checkValidity())
    searchQuery.tags = tags_input.value;

  date_bgn_input = document.getElementById("start_date");
  if (date_bgn_input.checkValidity())
    searchQuery.date_bgn = date_bgn_input.value;

  date_end_input = document.getElementById("end_date");
  if (date_end_input.checkValidity())
    searchQuery.date_end = date_end_input.value;

  min_width_input = document.getElementById("min_width");
  if (min_width_input.checkValidity())
    searchQuery.min_width = min_width_input.value;

  max_width_input = document.getElementById("max_width");
  if (max_width_input.checkValidity())
    searchQuery.max_width = max_width_input.value;

  min_height_input = document.getElementById("min_height");
  if (min_height_input.checkValidity())
    searchQuery.min_height = min_height_input.value;

  max_height_input = document.getElementById("max_height");
  if (max_height_input.checkValidity())
    searchQuery.max_height = max_height_input.value;

  max_size_input = document.getElementById("size");
  if (max_size_input.checkValidity())
    searchQuery.max_size = parseFloat(max_size_input.value) * 1024 * 1024; //size in bytes
}

function addUsernameToSearchQuery()
{
  searchQuery.user = document.title.split("'")[0];
}

function buildRequest()
{
  let request_text = api_link + "?";

  if (searchQuery.search){
    request_text += "search=" + searchQuery.search + "&";
  }
  if (searchQuery.tags){
    request_text += "tags=" + searchQuery.tags + "&";
  }
  if (searchQuery.date_bgn){
    request_text += "date_bgn=" + searchQuery.date_bgn + "&";
  }
  if (searchQuery.date_end){
    request_text += "date_end=" + searchQuery.date_end + "&";
  }
  if (searchQuery.min_size){
    request_text += "min_size=" + searchQuery.min_size + "&";
  }
  if (searchQuery.max_size){
    request_text += "max_size=" + searchQuery.max_size + "&";
  }
  if (searchQuery.min_width){
    request_text += "min_width=" + searchQuery.min_width + "&";
  }
  if (searchQuery.max_width){
    request_text += "max_width=" + searchQuery.max_width + "&";
  }
  if (searchQuery.min_height){
    request_text += "min_height=" + searchQuery.min_height + "&";
  }
  if (searchQuery.max_height){
    request_text += "max_height=" + searchQuery.max_height + "&";
  }
  if (searchQuery.user){
    request_text += "user=" + searchQuery.user + "&";
  }
  if (searchQuery.limit){
    request_text += "limit=" + searchQuery.limit + "&";
  }
  if (searchQuery.offset){
    request_text += "offset=" + searchQuery.offset + "&";
  }

  return request_text;
}