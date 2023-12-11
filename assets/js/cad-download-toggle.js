jQuery( function($) {
    $('.cad-downloads-toggle').click(function (){
        const downloadsList = $('.downloads-list');
        const cadDownloadToggle = $('.cad-downloads-toggle');
        if (downloadsList.hasClass('hidden')) {
            downloadsList.removeClass('hidden');
            cadDownloadToggle.html('Toon minder');
        } else {
            downloadsList.addClass('hidden');
            cadDownloadToggle.html('Toon alles');
        }
    });
});