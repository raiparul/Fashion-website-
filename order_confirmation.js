// order_confirmation.js

document.addEventListener('DOMContentLoaded', function() {
    // Dynamic thank you message
    const thankYouMessage = document.querySelector('p');
    if (thankYouMessage) {
        thankYouMessage.innerHTML = `Thank you for your purchase! Your order <strong>#${orderId}</strong> has been placed successfully.`;
    }

    // Auto redirect after a certain time (e.g., 10 seconds)
    const redirectToOrders = () => {
        window.location.href = 'view_orders.php';
    };

    setTimeout(redirectToOrders, 10000); // Redirect after 10 seconds

    // Show a countdown timer to the user
    let countdown = 10;
    const countdownElement = document.createElement('p');
    countdownElement.classList.add('mt-2');
    countdownElement.textContent = `You will be redirected to your orders in ${countdown} seconds...`;
    document.querySelector('.container').appendChild(countdownElement);

    const countdownInterval = setInterval(() => {
        countdown--;
        countdownElement.textContent = `You will be redirected to your orders in ${countdown} seconds...`;
        if (countdown <= 0) {
            clearInterval(countdownInterval);
        }
    }, 1000);
});
