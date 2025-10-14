/**
 * KML Group - Form Validation & Submission v1.0
 * Author: Janith Aththanayaka
 * URL: https://kmlgroup.lk
 * Description: Handles AJAX form validation and submission with custom alerts
 */

(function () {
  "use strict";

  // Select all forms with the class .kml-form
  let forms = document.querySelectorAll('.kml-form');

  forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      const thisForm = this;

      const action = thisForm.getAttribute('action');
      const recaptcha = thisForm.getAttribute('data-recaptcha-site-key');

      if (!action) {
        showError(thisForm, 'Form action is not defined. Please contact support.');
        return;
      }

      const loading = thisForm.querySelector('.loading');
      const errorMsg = thisForm.querySelector('.error-message');
      const successMsg = thisForm.querySelector('.sent-message');

      loading.classList.add('d-block');
      errorMsg.classList.remove('d-block');
      successMsg.classList.remove('d-block');

      const formData = new FormData(thisForm);

      // Handle reCaptcha if available
      if (recaptcha) {
        if (typeof grecaptcha !== "undefined") {
          grecaptcha.ready(function () {
            grecaptcha.execute(recaptcha, { action: 'form_submit' })
              .then(token => {
                formData.set('recaptcha-response', token);
                sendForm(thisForm, action, formData);
              })
              .catch(() => {
                showError(thisForm, 'reCAPTCHA validation failed.');
              });
          });
        } else {
          showError(thisForm, 'reCAPTCHA API not loaded.');
        }
      } else {
        sendForm(thisForm, action, formData);
      }
    });
  });

  // Send form via AJAX
  function sendForm(thisForm, action, formData) {
    fetch(action, {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(response => {
        if (response.ok) return response.json();
        throw new Error(`Network error: ${response.statusText}`);
      })
      .then(data => {
        thisForm.querySelector('.loading').classList.remove('d-block');
        if (data.status === 'success') {
          const successMsg = thisForm.querySelector('.sent-message');
          successMsg.innerHTML = data.message || 'Thank you! Your message has been sent successfully.';
          successMsg.classList.add('d-block');
          thisForm.reset();
        } else {
          throw new Error(data.message || 'Submission failed. Please try again later.');
        }
      })
      .catch(error => {
        showError(thisForm, error);
      });
  }

  // Display error message
  function showError(thisForm, error) {
    const loading = thisForm.querySelector('.loading');
    const errorMsg = thisForm.querySelector('.error-message');

    loading.classList.remove('d-block');
    errorMsg.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${error}`;
    errorMsg.classList.add('d-block');
  }

})();
