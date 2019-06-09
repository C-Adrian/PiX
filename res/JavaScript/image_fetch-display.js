//searchQuery can be found in query_build.js, which should be imported prior to this file

var currentResultsCount;

function fetchImages() 
{
  request_text = buildRequest();

  fetch(request_text)
    .then(resp => resp.json())
    .then(imgs => {
      currentResultsCount += imgs.length;
      if (imgs.length < FETCH_SIZE)
      {
        removeLoadMoreImagesButton();
      }

      let img_display = document.getElementById("image_display");

      for (img_index = 0; img_index < imgs.length; img_index++)
      {
        let img_div = document.createElement("div");
        img_div.className = "image_frame";

          let img_div_title = document.createElement("h4");
          img_div_title.className = "image_title";
          img_div_title.innerHTML = imgs[img_index].title;
          img_div.appendChild(img_div_title);

          let img_div_obj = document.createElement("div");
          img_div_obj.className = "image_object";
          img_div.appendChild(img_div_obj);

            let img_div_obj_img = document.createElement("img");
            img_div_obj_img.setAttribute("alt", "Not Available");
            img_div_obj_img.setAttribute("src", imgs[img_index].localPath);
            img_div_obj_img.setAttribute("onclick", "redirectToEdit(" + imgs[img_index].id + ")" );
            img_div_obj.appendChild(img_div_obj_img);

            let img_div_obj_btn = document.createElement("a");
            img_div_obj_btn.className = "download_button";
            img_div_obj_btn.innerHTML = "Download";
            img_div_obj_btn.setAttribute("href", imgs[img_index].localPath);
            filename = imgs[img_index].title + "." + imgs[img_index].localPath.split(".").pop();
            img_div_obj_btn.setAttribute("download", filename);
            img_div_obj.appendChild(img_div_obj_btn);

          let img_div_tags = document.createElement("p");
          img_div_tags.className = "image_tags";
          img_div_tags.innerHTML = imgs[img_index].tags;
          img_div.appendChild(img_div_tags);

        img_display.appendChild(img_div);
      }     
    })
    .catch(err => {
      alert("Could not retrieve images.");
    });
}

function fetchAllImages()
{
  emptySearchQuery();

  removeImages();
  fetchImages();
}

function fetchMyImages()
{
  emptySearchQuery();
  addUsernameToSearchQuery();

  removeImages();
  fetchImages();
}


function fetchImagesSimpleSearch()
{
  emptySearchQuery();
  buildSimpleSearchQuery();

  removeImages();
  addLoadMoreImagesButton();
  fetchImages();
}

function fetchMyImagesSimpleSearch()
{
  emptySearchQuery();
  buildSimpleSearchQuery();
  addUsernameToSearchQuery();

  removeImages();
  addLoadMoreImagesButton();
  fetchImages();
}

function fetchImagesAdvancedSearch()
{
  emptySearchQuery();
  buildAdvancedSearchQuery();

  removeImages();
  addLoadMoreImagesButton();
  fetchImages();

  toggleAdvSearch();
}

function fetchMyImagesAdvancedSearch()
{
  emptySearchQuery();
  buildAdvancedSearchQuery();
  addUsernameToSearchQuery();

  removeImages();
  addLoadMoreImagesButton();
  fetchImages();

  toggleAdvSearch();
}

function fetchMoreImages()
{
  updateSearchQuery();
  fetchImages();
}

function removeImages()
{
  let img_display = document.getElementById("image_display");
  while (img_display.firstChild)
  {
    img_display.removeChild(img_display.firstChild);
  }
  currentResultsCount = 0;
}

function addLoadMoreImagesButton()
{
  if (!document.getElementById("load_more_btn"))
  {
    let load_more_btn = document.createElement("button");
    load_more_btn.id = "load_more_btn";
    load_more_btn.innerHTML = "More images";
    load_more_btn.addEventListener("click", fetchMoreImages);
    document.getElementById("main").appendChild(load_more_btn);
  }
}

function removeLoadMoreImagesButton()
{
  if(document.getElementById("load_more_btn"))
  {
    let load_more_btn = document.getElementById("load_more_btn");
    document.getElementById("main").removeChild(load_more_btn);
  }
}