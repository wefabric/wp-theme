document.addEventListener('wpcf7mailsent', function( event ) {
    let contactFormId = event.detail.unitTag;
    if(!contactFormId) {
        return;
    }

    // If there is a contact form that also has the option to subscribe the sender to the newsletter,
    // grab the e-mailaddress and manually place it in the subscribe form in the footer. It's a bit
    // crude but it's the simplest form imaginable.

    // Use: Check the ID in the HTML of the form, then add it in the if-array and in the switch.
    // Every instance of a form must be added separately, although multiple instances of a form can
    // be grouped together in the switch (by using fall-through cases).
    if(['wpcf7-f1835-p1829-o1', 'wpcf7-f1835-p1829-o2'].includes(contactFormId)) {
        let email = '';
        switch (contactFormId) {
            case 'wpcf7-f1835-p1829-o1':
            case 'wpcf7-f1835-p1829-o2':
                email = event.detail.inputs[3]['value'];
                break;
        }

        if(email !== '') {
            $('#mc-embedded-subscribe-form input[type=email]').val(email);
            $('#mc-embedded-subscribe-form button').click();

            $('.wpcf7-response-output').css('display', 'none');
        }
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