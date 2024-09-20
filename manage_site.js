// manage_site.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const siteNameInput = document.getElementById('site_name');
    const siteDescriptionTextarea = document.getElementById('site_description');
    const submitButton = document.querySelector('button[type="submit"]');

    // Character counter for Site Description
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

    // Confirm before submitting the form
    form.addEventListener('submit', function(event) {
        const confirmation = confirm("Are you sure you want to save these changes?");
        if (!confirmation) {
            event.preventDefault(); // Prevent form submission if not confirmed
        }
    });

    // Simple form validation (example: Site Name cannot be empty)
    form.addEventListener('input', function() {
        const isFormValid = siteNameInput.value.trim() !== '' && siteDescriptionTextarea.value.trim() !== '';
        submitButton.disabled = !isFormValid;
    });

    // Initial validation check
    submitButton.disabled = siteNameInput.value.trim() === '' || siteDescriptionTextarea.value.trim() === '';
});
