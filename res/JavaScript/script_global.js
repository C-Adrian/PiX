function toggleAdvSearch() {
    let adv_searchBtn = document.getElementsByClassName('adv_searchBtn');
    let advSearch = document.querySelector('.advanced_search');

    if (advSearch.className.indexOf('is--open') != -1) {
        advSearch.classList.remove('is--open');
    }
    else {
        advSearch.classList.add('is--open');
    }
}
function redirectToEdit(imageId) {
    var imageIdCookie = "imageId=".concat(imageId.toString()).concat("; expires=0; path=/");
    //document.cookie = "imageId=1; expires=0; path=/";
    var initCookie = "init=1; expires=0; path=/";
    document.cookie = imageIdCookie;
    document.cookie = initCookie;
    window.location = "EditAndViewPage.php";
}
function checkOnlyOne(checkBox) {

    var checkBoxs = document.getElementsByClassName('filterCBX');
    var i;

    for (i = 0; i < checkBoxs.length; i++) {
        if (checkBoxs[i].value != checkBox) {
            checkBoxs[i].checked = false;
        }
    }
}