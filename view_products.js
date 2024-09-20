// view_products.js

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('#search');
    const productCards = document.querySelectorAll('.card');

    // Filter products based on search input
    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();
        
        productCards.forEach(function(card) {
            const productName = card.querySelector('.card-title').textContent.toLowerCase();
            const productDescription = card.querySelector('.card-text').textContent.toLowerCase();

            if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                card.parentElement.style.display = 'block'; // Show matching product
            } else {
                card.parentElement.style.display = 'none'; // Hide non-matching product
            }
        });
    });

    // Confirm before navigating to product details
    const viewDetailsButtons = document.querySelectorAll('.btn-primary');

    viewDetailsButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            const confirmation = confirm("Do you want to view the product details?");
            if (!confirmation) {
                event.preventDefault(); // Prevent navigation if not confirmed
            }
        });
    });
});
