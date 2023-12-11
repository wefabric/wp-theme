jQuery( function($) {

    $('.show-cart-coupon-totals-toggle').click(function (){
       $('.show-cart-coupon-totals-wrapper').toggleClass('hidden');
       $('.rotate-chevron').toggleClass('rotating');
    });

    $('input[name="coupon_code_totals"]').on('input', function (){
        $('.woocommerce-cart-form input[name="coupon_code"]').val($(this).val());
    });

    $('.apply_coupon_code_totals').click(function(){
        $('.woocommerce-cart-form button[name="apply_coupon"]').click();
    });
});