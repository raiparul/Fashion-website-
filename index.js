// script.js

document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for 'Shop Now' button
    const shopNowButton = document.querySelector('.btn-shop-now');
    if (shopNowButton) {
        shopNowButton.addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelector('.featured-products').scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Optional: Add animations or effects to featured products
    const featuredProducts = document.querySelectorAll('.featured-products .card');
    featuredProducts.forEach(card => {
        card.addEventListener('mouseover', function() {
            this.classList.add('shadow-lg');
        });
        card.addEventListener('mouseout', function() {
            this.classList.remove('shadow-lg');
        });
    });
});
