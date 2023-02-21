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
    let subscribe = false;
    let email = '';

    for (let i = 0; i <  event.detail.inputs.length; i++) {
        if(event.detail.inputs[i]['name'] === 'your-email') {
            email = event.detail.inputs[i]['value'];
        }
        if(event.detail.inputs[i]['name'] === 'newsletter[]') {
            subscribe = true;
        }
    }

    if(subscribe && email !== '') {
        $('#mc-embedded-subscribe-form input[type=email]').val(email);
        $('#mc-embedded-subscribe-form button').click();

        $('.wpcf7-response-output').css('display', 'none');
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