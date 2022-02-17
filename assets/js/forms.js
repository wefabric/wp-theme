document.addEventListener('wpcf7mailsent', function( event ) {
    let contactFormId = event.detail.unitTag;

    if(!contactFormId) {
        return;
    }

    let contactForm = document.getElementById(contactFormId);

    if (!contactForm) {
        return;
    }

    let redirectUrls = contactForm.getElementsByClassName("contact_form_success_redirect");

    if (redirectUrls.length < 1) {
        return;
    }

    let redirectUrl = redirectUrls[0];

    window.location = redirectUrl.value;
}, false );