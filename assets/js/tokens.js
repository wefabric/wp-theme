jQuery.ajax({
    url: '/token' ,
    type: 'get',
    dataType: 'json',
    success: function (response) {
        $('meta[name=csrf-token]').attr('content', response.csrf);
        $('input[name=_token]').val(response.csrf);
    },
});