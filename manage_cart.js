// manage_cart.js

document.addEventListener('DOMContentLoaded', function() {
    // Function to handle the removal of items from the cart
    const removeButtons = document.querySelectorAll('.btn-danger');
    removeButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                event.preventDefault();
            }
        });
    });

    // Function to handle the form submission for updating cart quantities
    const cartForm = document.querySelector('form');
    if (cartForm) {
        cartForm.addEventListener('submit', function(event) {
            const quantities = document.querySelectorAll('input[name^="quantities"]');
            let valid = true;

            quantities.forEach(input => {
                const value = parseInt(input.value, 10);
                if (value <= 0) {
                    alert('Quantity must be at least 1.');
                    valid = false;
                }
            });

            if (!valid) {
                event.preventDefault();
            }
        });
    }
});
