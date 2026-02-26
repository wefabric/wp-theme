$(document).ready(function() {
    const $modal = $("#theme-modal");
    if (!$modal.length) return;

    const displaySetting = $modal.data('display');

    if(displaySetting === 'always_display' || sessionStorage.getItem("modalStatus") !== "closed") {
        $modal.delay(500).fadeIn();
    }

    $('.theme-modal-close').click(function(e)
    {
        $modal.fadeOut();
        if (displaySetting === 'hide_after_closing') {
            sessionStorage.setItem("modalStatus", "closed")
        } else {
            sessionStorage.removeItem("modalStatus");
        }
    });
});