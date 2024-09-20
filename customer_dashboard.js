// dashboard.js

document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for "View All Products" button
    const viewProductsButton = document.querySelector('.btn-primary');
    if (viewProductsButton) {
        viewProductsButton.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = viewProductsButton.href;
        });
    }

    // Add confirmation dialog to logout button
    const logoutButton = document.querySelector('.btn-danger');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to logout?')) {
                event.preventDefault();
            }
        });
    }

    // Optional: Add some dynamic effects to the orders list
    const orderItems = document.querySelectorAll('.list-group-item');
    orderItems.forEach(item => {
        item.addEventListener('mouseover', function() {
            this.classList.add('bg-light');
        });
        item.addEventListener('mouseout', function() {
            this.classList.remove('bg-light');
        });
    });
});
