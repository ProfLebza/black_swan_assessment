/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)

import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

// require('jquery');
require('bootstrap/dist/js/bootstrap.js');
require('bootstrap/dist/css/bootstrap.min.css');

window.onGoogleReCaptchaApiLoad = () => {
    let widgets = document.querySelectorAll('[data-toggle="recaptcha"]');
    for (let i = 0; i < widgets.length; i++)
    {
        renderReCaptcha(widgets[i], window.siteKey);
    }
}

let renderReCaptcha = (widget, siteKey) => {
    let form = widget.closest('form');
    let widgetType = widget.getAttribute('data-type');
    let widgetParameters = {
        'sitekey': siteKey
    };

    if (widgetType === 'invisible') {
        widgetParameters['callback'] = () => {
            form.submit()
        };
        widgetParameters['size'] = "invisible";
    }

    let widgetId = grecaptcha.render(widget, widgetParameters);

    if (widgetType === 'invisible') {
        bindChallengeToSubmitButtons(form, widgetId);
    }
}

let bindChallengeToSubmitButtons = (form, reCaptchaId) => {
    getSubmitButtons(form).forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            grecaptcha.execute(reCaptchaId);
        });
    });
}

/**
 * Get the submit buttons from the given form
 */
let getSubmitButtons = (form) => {
    let buttons = form.querySelectorAll('button, input');
    let submitButtons = [];

    for (let i= 0; i < buttons.length; i++) {
        let button = buttons[i];
        if (button.getAttribute('type') === 'submit') {
            submitButtons.push(button);
        }
    }

    return submitButtons;
}