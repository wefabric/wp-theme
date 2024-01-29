$(document).ready(function() {
    if(sessionStorage.getItem("modalStatus") !== "closed") {
        $("#theme-modal").delay(500).fadeIn();
    }

    $('.theme-modal-close').click(function(e)
    {
        $('#theme-modal').fadeOut();
        sessionStorage.setItem("modalStatus", "closed")
    });
});