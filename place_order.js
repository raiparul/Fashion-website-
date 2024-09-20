// place_order.js

document.addEventListener('DOMContentLoaded', function() {
    const orderForm = document.querySelector('form');
    
    // Confirm before submitting the order
    orderForm.addEventListener('submit', function(event) {
        const confirmation = confirm("Are you sure you want to place this order?");
        if (!confirmation) {
            event.preventDefault(); // Prevent form submission if not confirmed
        }
    });

    // Disable the button after submitting to prevent multiple submissions
    orderForm.addEventListener('submit', function() {
        const submitButton = orderForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';
    });
});
