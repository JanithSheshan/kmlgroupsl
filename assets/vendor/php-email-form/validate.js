/**
 * PHP Email Form Validation - v3.6
 * URL: https://bootstrapmade.com/php-email-form/
 * Author: BootstrapMade.com
 * Adapted for KML Group - Handles both contact and newsletter forms
 */
(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form');

  forms.forEach( function(form) {
    form.addEventListener('submit', function(event) {
      event.preventDefault();

      let thisForm = this;

      let action = thisForm.getAttribute('action');
      let recaptcha = thisForm.getAttribute('data-recaptcha-site-key');
      
      if( ! action ) {
        displayError(thisForm, 'The form action property is not set!');
        return;
      }
      
      // Show loading state
      let loadingElement = thisForm.querySelector('.loading');
      let errorElement = thisForm.querySelector('.error-message');
      let sentElement = thisForm.querySelector('.sent-message');
      
      if (loadingElement) loadingElement.classList.add('d-block');
      if (errorElement) errorElement.classList.remove('d-block');
      if (sentElement) sentElement.classList.remove('d-block');

      let formData = new FormData( thisForm );

      if ( recaptcha ) {
        if(typeof grecaptcha !== "undefined" ) {
          grecaptcha.ready(function() {
            try {
              grecaptcha.execute(recaptcha, {action: 'php_email_form_submit'})
              .then(token => {
                formData.set('recaptcha-response', token);
                php_email_form_submit(thisForm, action, formData);
              })
            } catch(error) {
              displayError(thisForm, error);
            }
          });
        } else {
          displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
        }
      } else {
        php_email_form_submit(thisForm, action, formData);
      }
    });
  });

  function php_email_form_submit(thisForm, action, formData) {
    fetch(action, {
      method: 'POST',
      body: formData,
      headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => {
      if( response.ok ) {
        return response.json();
      } else {
        throw new Error(`${response.status} ${response.statusText} ${response.url}`); 
      }
    })
    .then(data => {
      let loadingElement = thisForm.querySelector('.loading');
      let sentElement = thisForm.querySelector('.sent-message');
      let errorElement = thisForm.querySelector('.error-message');
      
      if (loadingElement) loadingElement.classList.remove('d-block');
      
      if (data.status === 'success') {
        // Show success message in the form if element exists
        if (sentElement) {
          sentElement.innerHTML = data.message;
          sentElement.classList.add('d-block');
        }
        
        // Reset form on success
        thisForm.reset(); 
        
        // Show notification
        showNotification(data.message, 'success');
      } else {
        throw new Error(data.message ? data.message : 'Form submission failed and no error message returned from: ' + action); 
      }
    })
    .catch((error) => {
      displayError(thisForm, error);
      // Also show notification for errors
      showNotification(error.message, 'error');
    });
  }

  function displayError(thisForm, error) {
    let loadingElement = thisForm.querySelector('.loading');
    let errorElement = thisForm.querySelector('.error-message');
    
    if (loadingElement) loadingElement.classList.remove('d-block');
    if (errorElement) {
      errorElement.innerHTML = error;
      errorElement.classList.add('d-block');
    }
  }

  // Notification function for showing messages
  function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
        </div>
    `;
    
    // Add styles if not already added
    if (!document.querySelector('#notification-styles')) {
        const styles = document.createElement('style');
        styles.id = 'notification-styles';
        styles.innerHTML = `
            .notification {
                position: fixed;
                top: 100px;
                right: 20px;
                z-index: 10000;
                min-width: 300px;
                max-width: 500px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                border-left: 4px solid #2e8b57;
                animation: slideIn 0.3s ease-out;
            }
            .notification.error {
                border-left-color: #dc3545;
            }
            .notification.success {
                border-left-color: #28a745;
            }
            .notification-content {
                padding: 15px 20px;
                display: flex;
                justify-content: between;
                align-items: center;
            }
            .notification-message {
                flex: 1;
                margin-right: 10px;
                font-size: 14px;
                line-height: 1.4;
            }
            .notification-close {
                background: none;
                border: none;
                font-size: 18px;
                cursor: pointer;
                color: #666;
                padding: 0;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .notification-close:hover {
                color: #333;
            }
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(styles);
    }
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
  }

})();