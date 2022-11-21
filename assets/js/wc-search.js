window.toggleSearch = function (id) {
    let element = document.getElementById(id);
    element.classList.toggle("hidden");
    if(!element.classList.contains('hidden')) {
        let inputElements = element.getElementsByClassName('product-search-field');
        if(inputElements[0] !== 'undefined') {
            inputElements[0].focus();
        }
    }

}