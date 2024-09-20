// manage_users.js

document.addEventListener('DOMContentLoaded', function() {
    // Confirmation prompt before deleting a user
    const deleteButtons = document.querySelectorAll('button[value="delete"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const confirmation = confirm("Are you sure you want to delete this user?");
            if (!confirmation) {
                event.preventDefault(); // Prevent the form submission if not confirmed
            }
        });
    });

    // Character counter for Site Description
    const siteDescriptionTextarea = document.getElementById('site_description');
    const charCounter = document.createElement('small');
    charCounter.classList.add('form-text', 'text-muted');
    siteDescriptionTextarea.parentNode.appendChild(charCounter);

    function updateCharCounter() {
        const maxLength = siteDescriptionTextarea.getAttribute('maxlength') || 500;
        const currentLength = siteDescriptionTextarea.value.length;
        charCounter.textContent = `${currentLength}/${maxLength} characters used`;
    }

    siteDescriptionTextarea.addEventListener('input', updateCharCounter);

    // Initial counter update
    updateCharCounter();

    // Simple form validation for empty fields
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('input', function() {
            let isValid = true;

            const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
            requiredFields.forEach(field => {
                if (field.value.trim() === '') {
                    isValid = false;
                }
            });

            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = !isValid;
            }
        });
    });

    // Disable submit buttons initially if fields are empty
    forms.forEach(form => {
        const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (field.value.trim() === '') {
                isValid = false;
            }
        });

        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = !isValid;
        }
    });
});
