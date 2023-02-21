jQuery( document ).ready(function($) {
    $(document).on( 'change', '.variations select', function( event ) {

        console.log('yes');

        var select = $(this);
        var variations = $(this).parent().closest('.variations');

        $(variations).find('select').not(select).each(function() {

            var val = $(this).val();

            if($(this).find('option').length > 2) {
                return false;
            }

            if ( !val || ( val && !$(this).find('option[value='+val+']:enabled') ) ) {

                $(this).find('option:enabled').each(function() {

                    if ( $(this).attr('value') ) {

                        $(this).prop('selected', 'selected');
                        return false;

                    }

                });

            }

        });
    });
});