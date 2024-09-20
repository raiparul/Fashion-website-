// product_details.js

document.addEventListener('DOMContentLoaded', function() {
    const addToCartButton = document.querySelector('.btn-primary');
    const productImage = document.querySelector('.image-container img');
    
    // Confirm before adding the product to the cart
    addToCartButton.addEventListener('click', function(event) {
        const confirmation = confirm("Are you sure you want to add this product to your cart?");
        if (!confirmation) {
            event.preventDefault(); // Prevent the default action if not confirmed
        }
    });

    // Image zoom functionality on hover
    productImage.addEventListener('mouseover', function() {
        this.style.transform = 'scale(1.5)';
        this.style.transition = 'transform 0.25s ease';
    });

    productImage.addEventListener('mouseout', function() {
        this.style.transform = 'scale(1)';
    });
});
