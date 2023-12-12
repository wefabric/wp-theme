jQuery.ajax({
    url: '/dynamic-content' ,
    type: 'get',
    dataType: 'json',
    success: function (response) {
        if(typeof response.csrf !== 'undefined') {
            $('meta[name=csrf-token]').attr('content', response.csrf);
            $('input[name=_token]').val(response.csrf);
        }

        if(typeof response.cart !== 'undefined') {

            if(typeof response.cart.items_count !== 'undefined') {
                var cartItemsAmount = parseInt(response.cart.items_count);
                if(cartItemsAmount > 0) {
                    $('.cart-items-count').show().html(cartItemsAmount);
                }

            }

            if(typeof response.cart.amount !== 'undefined') {
                $('.cart-amount').html(response.cart.amount);
            }
        }

        if(typeof response.out_of_office !== 'undefined' && response.out_of_office) {
            $('body').append(response.out_of_office);

            if(sessionStorage.getItem("outOfOfficeStatus") !== "closed") {
                $("#popup").delay(500).fadeIn();
            }

            $('#popup-close').click(function(e) {
                $('#popup').fadeOut();
                sessionStorage.setItem("outOfOfficeStatus", "closed")
            });
        }

    },
});


// Get all the forms on the page
let allForms = document.querySelectorAll("form");

// Loop through all forms and add hidden input fields
for (var i = 0; i < allForms.length; i++) {
    let hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = '_token';
    hiddenInput.value = $('meta[name=csrf-token]').attr('content');
    allForms[i].appendChild(hiddenInput);
}