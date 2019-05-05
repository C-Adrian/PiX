function hideAdvSearch() {
    let adv_searchBtn = document.getElementsByClassName('adv_searchBtn');
    let advSearch = document.querySelector('.advanced_search');

    if (advSearch.className.indexOf('is--open') != -1) {
        advSearch.classList.remove('is--open');
    }
    else {
        advSearch.classList.add('is--open');
    }
}
function Redirect(imageId) {
    var str="imageId=".concat(imageId.toString()).concat("; expires=0; path=/");
    document.cookie = str;
    //document.cookie = "imageId=1; expires=0; path=/";
    window.location="EditAndViewPage.php";
 }