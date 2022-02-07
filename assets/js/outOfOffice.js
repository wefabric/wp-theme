$(document).ready(function() {
    if(sessionStorage.getItem("outOfOfficeStatus") !== "closed") {
        $("#popup").delay(500).fadeIn();
    }

    $('#popup-close').click(function(e)
    {
        $('#popup').fadeOut();
        sessionStorage.setItem("outOfOfficeStatus", "closed")
    });
});