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

jQuery( document ).ready(function($) {
    $('.product-search-filter-terms ul').each(function(){
        var max = 10
        var showMoreHtml = '<li class="show-toggle cursor-pointer"><i class="fa-solid fa-chevron-down pr-2"></i> Bekijk meer...</li>';
        if ($(this).find("li").length > max) {
            let item = $(this);
            item
                .find('li:gt('+max+')')
                .hide()
                .end()
                .append(
                    $(showMoreHtml).click( function(){
                        if($(this).hasClass('show-items')) {
                            $(this)
                                .siblings('.attribute-item:gt('+max+')')
                                .hide()
                                .end()
                                .toggleClass('show-items')
                                .html('<i class="fa-solid fa-chevron-down pr-2"></i> Bekijk meer...');
                        } else {
                            $(this)
                                .siblings('.attribute-item')
                                .show()
                                .end()
                                .toggleClass('show-items')
                                .html('<i class="fa-solid fa-chevron-up pr-2"></i> Bekijk minder...')
                        }

                    })
                );
        }
    });
});