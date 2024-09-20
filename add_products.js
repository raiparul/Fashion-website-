// add_product.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const imageInput = document.querySelector('input[name="image"]');
    const descriptionInput = document.querySelector('textarea[name="description"]');
    const charCounter = document.createElement('small');
    charCounter.classList.add('form-text', 'text-muted');
    descriptionInput.parentNode.appendChild(charCounter);
    const maxFileSize = 5 * 1024 * 1024; // 5MB

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const fileType = file.type;
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

           
            if (!validImageTypes.includes(fileType)) {
                alert('Please select a valid image file (JPG, PNG, GIF).');
                this.value = '';
                return;
            }

           
            if (file.size > maxFileSize) {
                alert('File size exceeds 5MB. Please select a smaller file.');
                this.value = '';
                return;
            }

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.style.maxWidth = '200px';
                preview.style.marginTop = '10px';

                // Remove previous preview if exists
                const existingPreview = document.querySelector('img.preview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                imageInput.parentNode.appendChild(preview);
                preview.classList.add('preview');
            }
            reader.readAsDataURL(file);
        }
    });

    // Character counter for Description
    function updateCharCounter() {
        const maxLength = descriptionInput.getAttribute('maxlength') || 500;
        const currentLength = descriptionInput.value.length;
        charCounter.textContent = `${currentLength}/${maxLength} characters used`;
    }

    descriptionInput.addEventListener('input', updateCharCounter);

    // Initial counter update
    updateCharCounter();

    // Form validation on submit
    form.addEventListener('submit', function(event) {
        const file = imageInput.files[0];

        if (!file) {
            alert('Please upload an image.');
            event.preventDefault();
            return;
        }

        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!validImageTypes.includes(fileType)) {
            alert('Please select a valid image file (JPG, PNG, GIF).');
            event.preventDefault();
            return;
        }

        if (file.size > maxFileSize) {
            alert('File size exceeds 5MB. Please select a smaller file.');
            event.preventDefault();
            return;
        }
    });
});
