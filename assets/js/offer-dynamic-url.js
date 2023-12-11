

jQuery( document ).ready(function($) {
    $('.offer-dynamic-url').click(function (e){
        let sku = $('.sku_wrapper .sku').text();
        let quantity = $('.quantity .qty').val() ?? 1;
        if(sku) {
            e.preventDefault();
            let url = decodeURI($(this).attr('href'));
            window.location.href = url.replace('{sku}', sku).replace('{quantity}',  quantity);
        }
    });
});