jQuery.ajax({
    url: '/dynamic' ,
    type: 'get',
    dataType: 'json',
    success: function (response) {
        if(typeof response.csrf !== 'undefined') {
            $('meta[name=csrf-token]').attr('content', response.csrf);
            $('input[name=_token]').val(response.csrf);
        }

        if(typeof response.cart !== 'undefined') {

            if(typeof response.cart.items_count !== 'undefined') {
                $('.cart-items-count').html(response.cart.items_count);
            }

            if(typeof response.cart.amount !== 'undefined') {
                $('.cart-amount').html(response.cart.amount);
            }
        }

    },
});