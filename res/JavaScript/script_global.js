function hideAdvSearch() {
    let adv_searchBtn = document.getElementById('adv_searchBtn');
    let advSearch = document.querySelector('.advanced_search');

    if (advSearch.className.indexOf('is--open') != -1) {
        advSearch.classList.remove('is--open');
    }
    else {
        advSearch.classList.add('is--open');
    }
}